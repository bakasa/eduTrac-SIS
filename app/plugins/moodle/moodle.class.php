<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
define('TOKEN', _h(get_option('moodle_token')));
define('DOMAIN', _h(get_option('moodle_install_url')));

class MoodleLMS
{
    /**
     * Holds the application object.
     * 
     * @since 1.0.9
     * @var unknown
     */
    public $app;

    public function __construct(\Liten\Liten $liten = null)
    {
        $this->app = ! empty($liten) ? $liten : \Liten\Liten::getInstance();
        
        $this->app->hook->add_action('post_save_person', [$this, 'create_moodle_user'], 10, 2);
        $this->app->hook->add_action('post_save_stu', [$this, 'update_moodle_student_auth'], 10, 1);
        $this->app->hook->add_action('post_save_myetsis_appl', [$this, 'create_moodle_user'], 10, 2);
        $this->app->hook->add_action('post_update_person', [$this, 'update_moodle_user'], 10, 1);
        $this->app->hook->add_action('post_reset_password', [$this, 'update_moodle_user_password'], 10, 1);
        $this->app->hook->add_action('post_change_password', [$this, 'update_moodle_user_password'], 10, 1);
        $this->app->hook->add_action('post_update_username', [$this, 'update_moodle_user_username'], 10, 1);
        $this->app->hook->add_action('post_save_myetsis_reg', [$this, 'enroll_moodle_student'], 10, 1);
        $this->app->hook->add_action('post_rgn_stu_crse_reg', [$this, 'enroll_moodle_student'], 10, 1);
        $this->app->hook->add_action('post_brgn_stu_crse_reg', [$this, 'enroll_moodle_student'], 10, 1);
        $this->app->hook->add_action('post_update_sacd', [$this, 'unenroll_moodle_student'], 10, 1);
        $this->app->hook->add_action('post_course_sec_addnl', [$this, 'enroll_moodle_teacher'], 10, 1);
        $this->app->hook->add_action('post_course_sec_addnl', [$this, 'update_moodle_teacher_auth'], 10, 1);
        $this->app->hook->add_action('post_update_course_sec', [$this, 'update_moodle_course'], 10, 1);
        $this->app->hook->add_action('post_save_subject', [$this, 'create_moodle_category'], 10, 2);
        $this->app->hook->add_action('post_save_course_sec', [$this, 'create_moodle_course'], 10, 1);
        $this->app->hook->add_action('left_sect_new_form', [$this, 'get_moodle_categories'], 10);
    }

    /**
     * Get Moodle categories and show a list of them
     * on the course section screen.
     * 
     * @since 1.0.0
     * @return mixed A dropdown list of Moodle categories.
     */
    public function get_moodle_categories()
    {
        $functionname = 'core_course_get_categories';
        $restformat = 'json';

        $categories = '{}';

        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname . '&moodlewsrestformat=' . $restformat;

        try {
            $categories = _file_get_contents($serverurl);
        } catch (Exception $e) {
            return $e;
        }

        $rows = json_decode($categories);

        echo '<!-- Group -->' . "\n";
        echo '<div class="form-group">' . "\n";
        echo '<label class="col-md-3 control-label"><font color="red">*</font>' . _t('Moodle Category', 'moodle') . '</label>' . "\n";
        echo '<div class="col-md-8">' . "\n";
        echo '<select name="moodleCat" class="selectpicker form-control" data-style="btn-info" data-size="10" data-live-search="true" required>' . "\n";
        echo '<option value="">&nbsp;</option>' . "\n";
        foreach ($rows as $data) {
            echo '<option value="' . $data->id . '">' . $data->name . '</option>' . "\n";
        }
        echo '</select>' . "\n";
        echo '</div>' . "\n";
        echo '</div>' . "\n";
        echo '<!-- // Group END -->';
    }

    /**
     * Moodle categories are created when subjects
     * in eduTrac SIS are created.
     * 
     * @since 1.0.0
     * @param array $subject Subject data object.
     * @return array JSON format.
     */
    public function create_moodle_category($subject)
    {
        $functionname = 'core_course_create_categories';
        $restformat = 'json';

        $category = new stdClass();
        $category->name = _h($subject['subjectName']);
        $category->parent = 0;
        $category->idnumber = _h($subject['subjectCode']);
        $category->description = _h($subject['subjectName']);
        $category->descriptionformat = 2;
        $categories = [ $category];
        $params = [ 'categories' => $categories];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        //print_r($resp);
        return $resp;
    }

    /**
     * Creates a course in Moodle when a course section
     * is created in eduTrac SIS.
     * 
     * @since 1.0.0
     * @param array $section Course section data array.
     * @return array JSON format.
     */
    public function create_moodle_course($section)
    {
        $app = \Liten\Liten::getInstance();
        $functionname = 'core_course_create_courses';
        $restformat = 'json';

        $Moodle_course = new stdClass();
        $Moodle_course->fullname = _h($section['secLongTitle']);
        $Moodle_course->shortname = _h($section['secShortTitle']);
        $Moodle_course->categoryid = $app->req->_post('moodleCat');
        $Moodle_course->idnumber = _h($section['courseSection']);
        $Moodle_course->summary = _escape($section['description']);
        $Moodle_course->summaryformat = 1;
        $Moodle_course->format = 'weeks';
        $Moodle_course->showgrades = 1;
        $Moodle_course->newsitems = 0;
        $Moodle_course->startdate = strtotime($section['startDate']);
        $Moodle_course->maxbytes = 20971520;
        $Moodle_course->showreports = 1;
        $Moodle_course->visible = 1;
        $Moodle_course->groupmode = 1;
        $Moodle_course->groupmodeforce = 0;
        $Moodle_course->defaultgroupingid = 0;
        $Moodle_course->enablecompletion = 1;
        $Moodle_course->completionnotify = 1;
        $MoodleCourses = [ $Moodle_course];
        $params = [ 'courses' => $MoodleCourses];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Retrieves the id of a Moodle user based on the user's
     * username.
     * 
     * @since 1.0.3
     * @param string $uname Username of a particular user.
     * @return int Moodle ID of user.
     */
    public function get_moodle_user_id_by_uname($uname)
    {
        $functionname = 'core_user_get_users_by_field';
        $restformat = 'json';

        $person = '{}';
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname . '&moodlewsrestformat=' . $restformat . '&field=username&values[0]=' . $uname;

        try {
            $person = _file_get_contents($serverurl);
        } catch (Exception $e) {
            return $e;
        }

        $rows = json_decode($person);

        foreach ($rows as $data) {
            return $data->id;
        }
    }

    /**
     * Retrieves the id of a Moodle user based on the user's
     * email.
     * 
     * @since 1.0.3
     * @param string $email Email of a particular user.
     * @return int Moodle ID of user.
     */
    public function get_moodle_user_id_by_email($email)
    {
        $functionname = 'core_user_get_users_by_field';
        $restformat = 'json';

        $person = '{}';
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname . '&moodlewsrestformat=' . $restformat . '&field=email&values[0]=' . $email;

        try {
            $person = _file_get_contents($serverurl);
        } catch (Exception $e) {
            return $e;
        }

        $rows = json_decode($person);

        foreach ($rows as $data) {
            return $data->id;
        }
    }

    /**
     * Retrieves the Moodle id based on the courseSection
     * name which is mapped to Moodle's idnumber field.
     * 
     * @since 1.0.3
     * @param string $courseSection Course section name.
     * @return int Moodle course id.
     */
    public function get_moodle_course_id($courseSection)
    {
        $functionname = 'core_course_get_courses';
        $restformat = 'json';

        $sect = '{}';
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname . '&moodlewsrestformat=' . $restformat;

        try {
            $sect = _file_get_contents($serverurl);
        } catch (Exception $e) {
            return $e;
        }

        $rows = json_decode($sect);

        foreach ($rows as $data) {
            while ($data->idnumber == $courseSection) {
                return $data->id;
            }
        }
    }

    /**
     * Creates a person in Moodle when the person is
     * created in eduTrac SIS.
     * 
     * @param string $pass Plaintext password.
     * @param array $nae Person data object.
     * @return array|bool
     */
    public function create_moodle_user($pass, $nae)
    {
        if ($nae->personType == 'STU' || $nae->personType == 'FAC' || $nae->personType == 'APL') {
            $functionname = 'core_user_create_users';
            $restformat = 'json';

            $user = new stdClass();
            $user->username = _h($nae->uname);
            $user->password = $pass;
            $user->firstname = _h($nae->fname);
            $user->lastname = _h($nae->lname);
            $user->email = _h($nae->email);
            $user->auth = _h(get_option('moodle_auth'));
            $user->idnumber = _h($nae->altID);
            $user->city = _h($nae->city);
            $user->country = _h($nae->country);
            $user->middlename = _h($nae->mname);

            $users = [ $user];
            $params = [ 'users' => $users];

            header('Content-Type: text/plain');
            $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
            require_once( 'curl.php' );
            $curl = new curl;
            $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
            $resp = $curl->post($serverurl . $restformat, $params);
            return $resp;
        } else {
            return false;
        }
    }

    /**
     * Updates Moodle user when information has been
     * updated in eduTrac SIS.
     * 
     * @since 1.0.3
     * @param array $person Person data object.
     * @return array|bool
     */
    public function update_moodle_user($person)
    {
        $functionname = 'core_user_update_users';
        $restformat = 'json';

        $user = new stdClass();
        $user->id = $this->get_moodle_user_id_by_uname(_h($person->uname));
        $user->firstname = _h($person->fname);
        $user->lastname = _h($person->lname);
        $user->email = _h($person->email);
        $user->idnumber = _h($person->altID);
        $user->middlename = _h($person->mname);
        $users = [ $user];
        $params = [ 'users' => $users];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Updated Moodle user's password when it is updated
     * in eduTrac SIS.
     * 
     * @since 1.0.3
     * @param string $pass Plaintext password.
     * @param string $uname Username of the user.
     */
    public function update_moodle_user_password($pass)
    {
        $functionname = 'core_user_update_users';
        $restformat = 'json';

        $user = new stdClass();
        $user->id = $this->get_moodle_user_id_by_uname(_h($pass['uname']));
        $user->password = $pass['pass'];
        $users = [ $user];
        $params = [ 'users' => $users];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Updated Moodle user's username when it is updated
     * in eduTrac SIS.
     * 
     * @since 1.0.3
     * @param string $person Person data object.
     */
    public function update_moodle_user_username($person)
    {
        $functionname = 'core_user_update_users';
        $restformat = 'json';

        $user = new stdClass();
        $user->id = $this->get_moodle_user_id_by_email(_h($person->email));
        $user->username = $person->uname;
        $users = [$user];
        $params = ['users' => $users];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }
    
    /**
     * Update Moodle teacher's auth when faculty
     * is added to course section in eduTrac SIS.
     * 
     * @since 1.0.5
     * @param string $section Course section data object.
     */
    public function update_moodle_teacher_auth($section)
    {
        if(_h(get_option('moodle_auth_teacher_update')) == 'no') {
            return;
        }
        $functionname = 'core_user_update_users';
        $restformat = 'json';

        $user = new stdClass();
        $user->id = $this->get_moodle_user_id_by_uname(get_user_value($section->facID, 'uname'));
        $user->auth = 'manual';
        $users = [ $user];
        $params = [ 'users' => $users];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }
    
    /**
     * Update Moodle student's auth when applicant
     * is moved to student in eduTrac SIS.
     * 
     * @since 1.0.5
     * @param string $spro Student data object.
     */
    public function update_moodle_student_auth($spro)
    {
        if(_h(get_option('moodle_auth_student_update')) == 'no') {
            return;
        }
        $functionname = 'core_user_update_users';
        $restformat = 'json';

        $user = new stdClass();
        $user->id = $this->get_moodle_user_id_by_uname($spro->uname);
        $user->auth = 'manual';
        $users = [ $user];
        $params = [ 'users' => $users];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Enrolls a user into the Moodle course and
     * assigns the student role.
     * 
     * @since 1.0.3
     * @param array $sacd Student Acaademic Cred data object.
     * @return array JSON format.
     */
    public function enroll_moodle_student($sacd)
    {
        $functionname = 'enrol_manual_enrol_users';
        $restformat = 'json';

        $enrolment = [ 'roleid' => 5, 'userid' => $this->get_moodle_user_id_by_uname($sacd->uname), 'courseid' => $this->get_moodle_course_id(_h($sacd->courseSection))];
        $enrolments = [ $enrolment];
        $params = [ 'enrolments' => $enrolments];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Unenrolls a student from the Moodle course when the
     * student is dropped or withdrawn from the eduTrac SIS
     * course section.
     * 
     * @since 1.0.4
     * @param array $sacd Student Acaademic Cred Detail data object.
     * @return array JSON format.
     */
    public function unenroll_moodle_student($sacd)
    {
        if (_h(get_option('moodle_unenroll_student')) == 'no' || _h(get_option('moodle_unenroll_student')) === null) {
            return;
        }
        if ($sacd->status == 'A' || $sacd->status == 'N') {
            return;
        }
        $functionname = 'enrol_manual_unenrol_users';
        $restformat = 'json';

        $enrolment = [ 'roleid' => 5, 'userid' => $this->get_moodle_user_id_by_uname($sacd->uname), 'courseid' => $this->get_moodle_course_id(_h($sacd->courseSection))];
        $enrolments = [ $enrolment];
        $params = [ 'enrolments' => $enrolments];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Add user to a Moodle course and
     * assigns the teacher role.
     * 
     * @since 1.0.3
     * @param array $section Course section data object.
     * @return array JSON format.
     */
    public function enroll_moodle_teacher($section)
    {
        $functionname = 'enrol_manual_enrol_users';
        $restformat = 'json';

        $enrolment = [ 'roleid' => 3, 'userid' => $this->get_moodle_user_id_by_uname(get_user_value(_h($section->facID), 'uname')), 'courseid' => $this->get_moodle_course_id(_h($section->courseSection))];
        $enrolments = [ $enrolment];
        $params = [ 'enrolments' => $enrolments];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }

    /**
     * Moodle course is updated when course section
     * in eduTrac SIS is updated.
     * 
     * @since 1.0.3
     * @param array $section Course section data object.
     * @return array JSON format.
     */
    public function update_moodle_course($section)
    {
        $functionname = 'core_course_update_courses';
        $restformat = 'json';

        $Moodle_course = new stdClass();
        if ($section->currStatus !== 'A') {
            $visible = 0;
        } else {
            $visible = 1;
        }
        $Moodle_course->id = $this->get_moodle_course_id(_h($section->courseSection));
        $Moodle_course->fullname = _h($section->courseLongTitle);
        $Moodle_course->shortname = _h($section->secShortTitle);
        $Moodle_course->idnumber = _h($section->courseSection);
        $Moodle_course->summary = _h($section->description);
        $Moodle_course->visible = $visible;
        $MoodleCourses = [ $Moodle_course];
        $params = [ 'courses' => $MoodleCourses];

        /// REST CALL
        header('Content-Type: text/plain');
        $serverurl = DOMAIN . '/webservice/rest/server.php' . '?wstoken=' . TOKEN . '&wsfunction=' . $functionname;
        require_once('curl.php');
        $curl = new curl;
        //if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
        $restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
        $resp = $curl->post($serverurl . $restformat, $params);
        return $resp;
    }
}
