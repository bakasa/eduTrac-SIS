/* parser generated by jison 0.4.15 */
/*
  Returns a Parser object of the following structure:

  Parser: {
    yy: {}
  }

  Parser.prototype: {
    yy: {},
    trace: function(),
    symbols_: {associative list: name ==> number},
    terminals_: {associative list: number ==> name},
    productions_: [...],
    performAction: function anonymous(yytext, yyleng, yylineno, yy, yystate, $$, _$),
    table: [...],
    defaultActions: {...},
    parseError: function(str, hash),
    parse: function(input),

    lexer: {
        EOF: 1,
        parseError: function(str, hash),
        setInput: function(input),
        input: function(),
        unput: function(str),
        more: function(),
        less: function(n),
        pastInput: function(),
        upcomingInput: function(),
        showPosition: function(),
        test_match: function(regex_match_array, rule_index),
        next: function(),
        lex: function(),
        begin: function(condition),
        popState: function(),
        _currentRules: function(),
        topState: function(),
        pushState: function(condition),

        options: {
            ranges: boolean           (optional: true ==> token location info will include a .range[] member)
            flex: boolean             (optional: true ==> flex-like lexing behaviour where the rules are tested exhaustively to find the longest match)
            backtrack_lexer: boolean  (optional: true ==> lexer regexes are tested in order and for each matching regex the action code is invoked; the lexer terminates the scan when a token is returned by the action code)
        },

        performAction: function(yy, yy_, $avoiding_name_collisions, YY_START),
        rules: [...],
        conditions: {associative list: name ==> set},
    }
  }


  token location info (@$, _$, etc.): {
    first_line: n,
    last_line: n,
    first_column: n,
    last_column: n,
    range: [start_number, end_number]       (where the numbers are indexes into the input string, regular zero-based)
  }


  the parseError function receives a 'hash' object with these members for lexer and parser errors: {
    text:        (matched text)
    token:       (the produced terminal token, if any)
    line:        (yylineno)
  }
  while parser (grammar) errors will also provide these members, i.e. parser errors deliver a superset of attributes: {
    loc:         (yylloc)
    expected:    (string describing the set of expected tokens)
    recoverable: (boolean: TRUE when the parser has a error recovery rule available for this particular error)
  }
*/
var parser = (function(){
var o=function(k,v,o,l){for(o=o||{},l=k.length;l--;o[k[l]]=v);return o},$V0=[1,8],$V1=[5,26],$V2=[1,14],$V3=[1,13],$V4=[5,26,31,42],$V5=[1,17],$V6=[5,26,31,42,45,62],$V7=[1,27],$V8=[1,29],$V9=[1,38],$Va=[1,42],$Vb=[1,43],$Vc=[1,39],$Vd=[1,40],$Ve=[1,37],$Vf=[1,41],$Vg=[1,25],$Vh=[5,26,31],$Vi=[5,26,31,42,45],$Vj=[1,55],$Vk=[18,43],$Vl=[1,58],$Vm=[1,59],$Vn=[1,60],$Vo=[1,61],$Vp=[1,62],$Vq=[5,18,23,26,31,34,37,38,41,42,43,45,62,64,65,66,67,68,70],$Vr=[5,18,23,26,31,34,37,38,41,42,43,44,45,51,62,64,65,66,67,68,70,71],$Vs=[1,67],$Vt=[2,82],$Vu=[1,81],$Vv=[1,82],$Vw=[1,99],$Vx=[5,26,31,42,43,44],$Vy=[1,107],$Vz=[5,26,31,42,43,45,64],$VA=[5,26,31,41,42,45,62],$VB=[1,110],$VC=[1,111],$VD=[1,112],$VE=[5,26,31,34,35,37,38,41,42,45,62],$VF=[5,18,23,26,31,34,37,38,41,42,43,45,62,64,70],$VG=[5,26,31,34,37,38,41,42,45,62],$VH=[5,26,31,42,56,58];
var parser = {trace: function trace() { },
yy: {},
symbols_: {"error":2,"Root":3,"Query":4,"EOF":5,"SelectQuery":6,"Unions":7,"SelectWithLimitQuery":8,"BasicSelectQuery":9,"Select":10,"OrderClause":11,"GroupClause":12,"LimitClause":13,"SelectClause":14,"WhereClause":15,"SELECT":16,"Fields":17,"FROM":18,"Table":19,"DISTINCT":20,"Joins":21,"Literal":22,"AS":23,"LEFT_PAREN":24,"List":25,"RIGHT_PAREN":26,"WINDOW":27,"WINDOW_FUNCTION":28,"Number":29,"Union":30,"UNION":31,"ALL":32,"Join":33,"JOIN":34,"ON":35,"Expression":36,"LEFT":37,"RIGHT":38,"INNER":39,"OUTER":40,"WHERE":41,"LIMIT":42,"SEPARATOR":43,"OFFSET":44,"ORDER":45,"BY":46,"OrderArgs":47,"OffsetClause":48,"OrderArg":49,"Value":50,"DIRECTION":51,"OffsetRows":52,"FetchClause":53,"ROW":54,"ROWS":55,"FETCH":56,"FIRST":57,"ONLY":58,"NEXT":59,"GroupBasicClause":60,"HavingClause":61,"GROUP":62,"ArgumentList":63,"HAVING":64,"MATH":65,"MATH_MULTI":66,"OPERATOR":67,"BETWEEN":68,"BetweenExpression":69,"CONDITIONAL":70,"SUB_SELECT_OP":71,"SubSelectExpression":72,"SUB_SELECT_UNARY_OP":73,"String":74,"Function":75,"UserFunction":76,"Boolean":77,"Parameter":78,"NUMBER":79,"BOOLEAN":80,"PARAMETER":81,"STRING":82,"DBLSTRING":83,"LITERAL":84,"DOT":85,"FUNCTION":86,"AggregateArgumentList":87,"Field":88,"STAR":89,"$accept":0,"$end":1},
terminals_: {2:"error",5:"EOF",16:"SELECT",18:"FROM",20:"DISTINCT",23:"AS",24:"LEFT_PAREN",26:"RIGHT_PAREN",27:"WINDOW",28:"WINDOW_FUNCTION",31:"UNION",32:"ALL",34:"JOIN",35:"ON",37:"LEFT",38:"RIGHT",39:"INNER",40:"OUTER",41:"WHERE",42:"LIMIT",43:"SEPARATOR",44:"OFFSET",45:"ORDER",46:"BY",51:"DIRECTION",54:"ROW",55:"ROWS",56:"FETCH",57:"FIRST",58:"ONLY",59:"NEXT",62:"GROUP",64:"HAVING",65:"MATH",66:"MATH_MULTI",67:"OPERATOR",68:"BETWEEN",70:"CONDITIONAL",71:"SUB_SELECT_OP",73:"SUB_SELECT_UNARY_OP",79:"NUMBER",80:"BOOLEAN",81:"PARAMETER",82:"STRING",83:"DBLSTRING",84:"LITERAL",85:"DOT",86:"FUNCTION",89:"STAR"},
productions_: [0,[3,2],[4,1],[4,2],[6,1],[6,1],[9,1],[9,2],[9,2],[9,3],[8,2],[10,1],[10,2],[14,4],[14,5],[14,5],[14,6],[19,1],[19,2],[19,3],[19,3],[19,3],[19,4],[19,6],[7,1],[7,2],[30,2],[30,3],[21,1],[21,2],[33,4],[33,5],[33,5],[33,6],[33,6],[33,6],[33,6],[15,2],[13,2],[13,4],[13,4],[11,3],[11,4],[47,1],[47,3],[49,1],[49,2],[48,2],[48,3],[52,2],[52,2],[53,4],[53,4],[12,1],[12,2],[60,3],[61,2],[36,3],[36,3],[36,3],[36,3],[36,3],[36,3],[36,5],[36,3],[36,2],[36,1],[69,3],[72,3],[50,1],[50,1],[50,1],[50,1],[50,1],[50,1],[50,1],[25,1],[29,1],[77,1],[78,1],[74,1],[74,1],[22,1],[22,3],[75,4],[76,4],[87,1],[87,2],[63,1],[63,3],[17,1],[17,3],[88,1],[88,1],[88,3]],
performAction: function anonymous(yytext, yyleng, yylineno, yy, yystate /* action[1] */, $$ /* vstack */, _$ /* lstack */) {
/* this == yyval */

var $0 = $$.length - 1;
switch (yystate) {
case 1:
return this.$ = $$[$0-1];
break;
case 2: case 4: case 5: case 6: case 11: case 53: case 66: case 69: case 70: case 71: case 72: case 73: case 74: case 75:
this.$ = $$[$0];
break;
case 3:
this.$ = (function () {
        $$[$0-1].unions = $$[$0];
        return $$[$0-1];
      }());
break;
case 7:
this.$ = (function () {
        $$[$0-1].order = $$[$0];
        return $$[$0-1];
      }());
break;
case 8:
this.$ = (function () {
        $$[$0-1].group = $$[$0];
        return $$[$0-1];
      }());
break;
case 9:
this.$ = (function () {
        $$[$0-2].group = $$[$0-1];
        $$[$0-2].order = $$[$0];
        return $$[$0-2];
      }());
break;
case 10:
this.$ = (function () {
        $$[$0-1].limit = $$[$0];
        return $$[$0-1];
      }());
break;
case 12:
this.$ = (function () {
        $$[$0-1].where = $$[$0];
        return $$[$0-1];
      }());
break;
case 13:
this.$ = new yy.Select($$[$0-2], $$[$0], false);
break;
case 14:
this.$ = new yy.Select($$[$0-2], $$[$0], true);
break;
case 15:
this.$ = new yy.Select($$[$0-3], $$[$0-1], false, $$[$0]);
break;
case 16:
this.$ = new yy.Select($$[$0-3], $$[$0-1], true, $$[$0]);
break;
case 17:
this.$ = new yy.Table($$[$0]);
break;
case 18:
this.$ = new yy.Table($$[$0-1], $$[$0]);
break;
case 19:
this.$ = new yy.Table($$[$0-2], $$[$0]);
break;
case 20: case 49: case 50: case 51: case 52: case 57:
this.$ = $$[$0-1];
break;
case 21: case 68:
this.$ = new yy.SubSelect($$[$0-1]);
break;
case 22:
this.$ = new yy.SubSelect($$[$0-2], $$[$0]);
break;
case 23:
this.$ = new yy.Table($$[$0-5], null, $$[$0-4], $$[$0-3], $$[$0-1]);
break;
case 24: case 28: case 43: case 88: case 90:
this.$ = [$$[$0]];
break;
case 25:
this.$ = $$[$0-1].concat($$[$01]);
break;
case 26:
this.$ = new yy.Union($$[$0]);
break;
case 27:
this.$ = new yy.Union($$[$0], true);
break;
case 29:
this.$ = $$[$0-1].concat($$[$0]);
break;
case 30:
this.$ = new yy.Join($$[$0-2], $$[$0]);
break;
case 31:
this.$ = new yy.Join($$[$0-2], $$[$0], 'LEFT');
break;
case 32:
this.$ = new yy.Join($$[$0-2], $$[$0], 'RIGHT');
break;
case 33:
this.$ = new yy.Join($$[$0-2], $$[$0], 'LEFT', 'INNER');
break;
case 34:
this.$ = new yy.Join($$[$0-2], $$[$0], 'RIGHT', 'INNER');
break;
case 35:
this.$ = new yy.Join($$[$0-2], $$[$0], 'LEFT', 'OUTER');
break;
case 36:
this.$ = new yy.Join($$[$0-2], $$[$0], 'RIGHT', 'OUTER');
break;
case 37:
this.$ = new yy.Where($$[$0]);
break;
case 38:
this.$ = new yy.Limit($$[$0]);
break;
case 39:
this.$ = new yy.Limit($$[$0], $$[$0-2]);
break;
case 40:
this.$ = new yy.Limit($$[$0-2], $$[$0]);
break;
case 41:
this.$ = new yy.Order($$[$0]);
break;
case 42:
this.$ = new yy.Order($$[$0-1], $$[$0]);
break;
case 44: case 89: case 91:
this.$ = $$[$0-2].concat($$[$0]);
break;
case 45:
this.$ = new yy.OrderArgument($$[$0], 'ASC');
break;
case 46:
this.$ = new yy.OrderArgument($$[$0-1], $$[$0]);
break;
case 47:
this.$ = new yy.Offset($$[$0]);
break;
case 48:
this.$ = new yy.Offset($$[$0-1], $$[$0]);
break;
case 54:
this.$ = (function () {
        $$[$0-1].having = $$[$0];
        return $$[$0-1];
      }());
break;
case 55:
this.$ = new yy.Group($$[$0]);
break;
case 56:
this.$ = new yy.Having($$[$0]);
break;
case 58: case 59: case 60: case 61: case 62: case 64:
this.$ = new yy.Op($$[$0-1], $$[$0-2], $$[$0]);
break;
case 63:
this.$ = new yy.Op($$[$0-3], $$[$0-4], $$[$0-1]);
break;
case 65:
this.$ = new yy.UnaryOp($$[$0-1], $$[$0]);
break;
case 67:
this.$ = new yy.BetweenOp([$$[$0-2], $$[$0]]);
break;
case 76:
this.$ = new yy.ListValue($$[$0]);
break;
case 77:
this.$ = new yy.NumberValue($$[$0]);
break;
case 78:
this.$ = new yy.BooleanValue($$[$0]);
break;
case 79:
this.$ = new yy.ParameterValue($$[$0]);
break;
case 80:
this.$ = new yy.StringValue($$[$0], "'");
break;
case 81:
this.$ = new yy.StringValue($$[$0], '"');
break;
case 82:
this.$ = new yy.LiteralValue($$[$0]);
break;
case 83:
this.$ = new yy.LiteralValue($$[$0-2], $$[$0]);
break;
case 84:
this.$ = new yy.FunctionValue($$[$0-3], $$[$0-1]);
break;
case 85:
this.$ = new yy.FunctionValue($$[$0-3], $$[$0-1], true);
break;
case 86:
this.$ = new yy.ArgumentListValue($$[$0]);
break;
case 87:
this.$ = new yy.ArgumentListValue($$[$0], true);
break;
case 92:
this.$ = new yy.Star();
break;
case 93:
this.$ = new yy.Field($$[$0]);
break;
case 94:
this.$ = new yy.Field($$[$0-2], $$[$0]);
break;
}
},
table: [{3:1,4:2,6:3,8:4,9:5,10:6,14:7,16:$V0},{1:[3]},{5:[1,9]},o($V1,[2,2],{7:10,13:11,30:12,31:$V2,42:$V3}),o($V4,[2,4]),o($V4,[2,5]),o($V4,[2,6],{11:15,12:16,60:18,45:$V5,62:[1,19]}),o($V6,[2,11],{15:20,41:[1,21]}),{17:22,20:[1,23],22:30,24:$V7,29:31,36:26,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf,88:24,89:$Vg},{1:[2,1]},o($V1,[2,3],{30:44,31:$V2}),o($V4,[2,10]),o($Vh,[2,24]),{29:45,79:$V9},{6:46,8:4,9:5,10:6,14:7,16:$V0,32:[1,47]},o($V4,[2,7]),o($V4,[2,8],{11:48,45:$V5}),{46:[1,49]},o($Vi,[2,53],{61:50,64:[1,51]}),{46:[1,52]},o($V6,[2,12]),{22:30,24:$V7,29:31,36:53,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{18:[1,54],43:$Vj},{17:56,22:30,24:$V7,29:31,36:26,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf,88:24,89:$Vg},o($Vk,[2,90]),o($Vk,[2,92]),o($Vk,[2,93],{23:[1,57],65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),{22:30,24:$V7,29:31,36:63,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($Vq,[2,66],{71:[1,64]}),{24:[1,66],72:65},o($Vr,[2,69],{85:$Vs}),o($Vr,[2,70]),o($Vr,[2,71]),o($Vr,[2,72]),o($Vr,[2,73]),o($Vr,[2,74]),o($Vr,[2,75]),o([5,18,23,26,31,34,37,38,41,42,43,44,45,51,62,64,65,66,67,68,70,71,85],$Vt,{24:[1,68]}),o([5,18,23,26,31,34,37,38,41,42,43,44,45,51,54,55,62,64,65,66,67,68,70,71],[2,77]),o($Vr,[2,80]),o($Vr,[2,81]),{24:[1,69]},o($Vr,[2,78]),o($Vr,[2,79]),o($Vh,[2,25]),o($V4,[2,38],{43:[1,70],44:[1,71]}),o($Vh,[2,26],{13:11,42:$V3}),{6:72,8:4,9:5,10:6,14:7,16:$V0},o($V4,[2,9]),{22:30,29:31,47:73,49:74,50:75,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($Vi,[2,54]),{22:30,24:$V7,29:31,36:76,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:78,50:28,63:77,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($V6,[2,37],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),{19:79,22:80,24:$Vu,84:$Vv},{22:30,24:$V7,29:31,36:26,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf,88:83,89:$Vg},{18:[1,84],43:$Vj},{22:85,84:$Vv},{22:30,24:$V7,29:31,36:86,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:87,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:88,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:90,50:28,69:89,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:91,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{26:[1,92],65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp},{24:[1,93],72:94},o($Vq,[2,65]),{4:95,6:3,8:4,9:5,10:6,14:7,16:$V0},{84:[1,96]},{20:$Vw,22:30,24:$V7,29:31,36:78,50:28,63:98,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf,87:97},{20:$Vw,22:30,24:$V7,29:31,36:78,50:28,63:98,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf,87:100},{29:101,79:$V9},{29:102,79:$V9},o($Vh,[2,27],{13:11,42:$V3}),o($V4,[2,41],{48:103,43:[1,104],44:[1,105]}),o($Vx,[2,43]),o($Vx,[2,45],{51:[1,106]}),o($Vi,[2,56],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),o([5,26,31,42,45,64],[2,55],{43:$Vy}),o($Vz,[2,88],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),o($VA,[2,13],{21:108,33:109,34:$VB,37:$VC,38:$VD}),o($VE,[2,17],{22:113,23:[1,114],27:[1,115],84:$Vv,85:$Vs}),{4:117,6:3,8:4,9:5,10:6,14:7,16:$V0,22:30,24:$V7,25:116,29:31,36:78,50:28,63:118,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o([5,18,23,26,27,31,34,35,37,38,41,42,43,45,62,84,85],$Vt),o($Vk,[2,91]),{19:119,22:80,24:$Vu,84:$Vv},o($Vk,[2,94],{85:$Vs}),o([5,18,23,26,31,34,37,38,41,42,43,45,62,64,65,67,70],[2,58],{66:$Vm,68:$Vo}),o([5,18,23,26,31,34,37,38,41,42,43,45,62,64,65,66,67,70],[2,59],{68:$Vo}),o([5,18,23,26,31,34,37,38,41,42,43,45,62,64,67,70],[2,60],{65:$Vl,66:$Vm,68:$Vo}),o($Vq,[2,61]),{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:[1,120]},o($VF,[2,62],{65:$Vl,66:$Vm,67:$Vn,68:$Vo}),o($Vq,[2,57]),{4:95,6:3,8:4,9:5,10:6,14:7,16:$V0,22:30,24:$V7,25:121,29:31,36:78,50:28,63:118,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($Vq,[2,64]),{26:[1,122]},o([5,18,23,26,27,31,34,35,37,38,41,42,43,44,45,51,62,64,65,66,67,68,70,71,84,85],[2,83]),{26:[1,123]},{26:[2,86],43:$Vy},{22:30,24:$V7,29:31,36:78,50:28,63:124,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{26:[1,125]},o($V4,[2,39]),o($V4,[2,40]),o($V4,[2,42]),{22:30,29:31,49:126,50:75,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{29:128,52:127,79:$V9},o($Vx,[2,46]),{22:30,29:31,50:129,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($VA,[2,15],{33:130,34:$VB,37:$VC,38:$VD}),o($VG,[2,28]),{19:131,22:80,24:$Vu,84:$Vv},{34:[1,132],39:[1,133],40:[1,134]},{34:[1,135],39:[1,136],40:[1,137]},o($VE,[2,18],{85:$Vs}),{22:138,84:$Vv},{28:[1,139]},{26:[1,140]},{26:[1,141]},{26:[2,76],43:$Vy},o($VA,[2,14],{33:109,21:142,34:$VB,37:$VC,38:$VD}),{22:30,24:$V7,29:31,36:143,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{26:[1,144]},o($Vq,[2,68]),o($Vr,[2,85]),{26:[2,87],43:$Vy},o($Vr,[2,84]),o($Vx,[2,44]),o($V4,[2,47],{53:145,56:[1,146]}),{54:[1,147],55:[1,148]},o($Vz,[2,89]),o($VG,[2,29]),{35:[1,149]},{19:150,22:80,24:$Vu,84:$Vv},{34:[1,151]},{34:[1,152]},{19:153,22:80,24:$Vu,84:$Vv},{34:[1,154]},{34:[1,155]},o($VE,[2,19],{85:$Vs}),{24:[1,156]},o($VE,[2,20]),o($VE,[2,21],{22:157,84:$Vv}),o($VA,[2,16],{33:130,34:$VB,37:$VC,38:$VD}),o($VF,[2,67],{65:$Vl,66:$Vm,67:$Vn,68:$Vo}),o($Vq,[2,63]),o($V4,[2,48]),{57:[1,158],59:[1,159]},o($VH,[2,49]),o($VH,[2,50]),{22:30,24:$V7,29:31,36:160,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{35:[1,161]},{19:162,22:80,24:$Vu,84:$Vv},{19:163,22:80,24:$Vu,84:$Vv},{35:[1,164]},{19:165,22:80,24:$Vu,84:$Vv},{19:166,22:80,24:$Vu,84:$Vv},{29:167,79:$V9},o($VE,[2,22],{85:$Vs}),{29:128,52:168,79:$V9},{29:128,52:169,79:$V9},o($VG,[2,30],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),{22:30,24:$V7,29:31,36:170,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{35:[1,171]},{35:[1,172]},{22:30,24:$V7,29:31,36:173,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{35:[1,174]},{35:[1,175]},{26:[1,176]},{58:[1,177]},{58:[1,178]},o($VG,[2,31],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),{22:30,24:$V7,29:31,36:179,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:180,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($VG,[2,32],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),{22:30,24:$V7,29:31,36:181,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},{22:30,24:$V7,29:31,36:182,50:28,73:$V8,74:32,75:33,76:34,77:35,78:36,79:$V9,80:$Va,81:$Vb,82:$Vc,83:$Vd,84:$Ve,86:$Vf},o($VE,[2,23]),o($V4,[2,51]),o($V4,[2,52]),o($VG,[2,33],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),o($VG,[2,35],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),o($VG,[2,34],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp}),o($VG,[2,36],{65:$Vl,66:$Vm,67:$Vn,68:$Vo,70:$Vp})],
defaultActions: {9:[2,1]},
parseError: function parseError(str, hash) {
    if (hash.recoverable) {
        this.trace(str);
    } else {
        throw new Error(str);
    }
},
parse: function parse(input) {
    var self = this, stack = [0], tstack = [], vstack = [null], lstack = [], table = this.table, yytext = '', yylineno = 0, yyleng = 0, recovering = 0, TERROR = 2, EOF = 1;
    var args = lstack.slice.call(arguments, 1);
    var lexer = Object.create(this.lexer);
    var sharedState = { yy: {} };
    for (var k in this.yy) {
        if (Object.prototype.hasOwnProperty.call(this.yy, k)) {
            sharedState.yy[k] = this.yy[k];
        }
    }
    lexer.setInput(input, sharedState.yy);
    sharedState.yy.lexer = lexer;
    sharedState.yy.parser = this;
    if (typeof lexer.yylloc == 'undefined') {
        lexer.yylloc = {};
    }
    var yyloc = lexer.yylloc;
    lstack.push(yyloc);
    var ranges = lexer.options && lexer.options.ranges;
    if (typeof sharedState.yy.parseError === 'function') {
        this.parseError = sharedState.yy.parseError;
    } else {
        this.parseError = Object.getPrototypeOf(this).parseError;
    }
    function popStack(n) {
        stack.length = stack.length - 2 * n;
        vstack.length = vstack.length - n;
        lstack.length = lstack.length - n;
    }
    _token_stack:
        function lex() {
            var token;
            token = lexer.lex() || EOF;
            if (typeof token !== 'number') {
                token = self.symbols_[token] || token;
            }
            return token;
        }
    var symbol, preErrorSymbol, state, action, a, r, yyval = {}, p, len, newState, expected;
    while (true) {
        state = stack[stack.length - 1];
        if (this.defaultActions[state]) {
            action = this.defaultActions[state];
        } else {
            if (symbol === null || typeof symbol == 'undefined') {
                symbol = lex();
            }
            action = table[state] && table[state][symbol];
        }
                    if (typeof action === 'undefined' || !action.length || !action[0]) {
                var errStr = '';
                expected = [];
                for (p in table[state]) {
                    if (this.terminals_[p] && p > TERROR) {
                        expected.push('\'' + this.terminals_[p] + '\'');
                    }
                }
                if (lexer.showPosition) {
                    errStr = 'Parse error on line ' + (yylineno + 1) + ':\n' + lexer.showPosition() + '\nExpecting ' + expected.join(', ') + ', got \'' + (this.terminals_[symbol] || symbol) + '\'';
                } else {
                    errStr = 'Parse error on line ' + (yylineno + 1) + ': Unexpected ' + (symbol == EOF ? 'end of input' : '\'' + (this.terminals_[symbol] || symbol) + '\'');
                }
                this.parseError(errStr, {
                    text: lexer.match,
                    token: this.terminals_[symbol] || symbol,
                    line: lexer.yylineno,
                    loc: yyloc,
                    expected: expected
                });
            }
        if (action[0] instanceof Array && action.length > 1) {
            throw new Error('Parse Error: multiple actions possible at state: ' + state + ', token: ' + symbol);
        }
        switch (action[0]) {
        case 1:
            stack.push(symbol);
            vstack.push(lexer.yytext);
            lstack.push(lexer.yylloc);
            stack.push(action[1]);
            symbol = null;
            if (!preErrorSymbol) {
                yyleng = lexer.yyleng;
                yytext = lexer.yytext;
                yylineno = lexer.yylineno;
                yyloc = lexer.yylloc;
                if (recovering > 0) {
                    recovering--;
                }
            } else {
                symbol = preErrorSymbol;
                preErrorSymbol = null;
            }
            break;
        case 2:
            len = this.productions_[action[1]][1];
            yyval.$ = vstack[vstack.length - len];
            yyval._$ = {
                first_line: lstack[lstack.length - (len || 1)].first_line,
                last_line: lstack[lstack.length - 1].last_line,
                first_column: lstack[lstack.length - (len || 1)].first_column,
                last_column: lstack[lstack.length - 1].last_column
            };
            if (ranges) {
                yyval._$.range = [
                    lstack[lstack.length - (len || 1)].range[0],
                    lstack[lstack.length - 1].range[1]
                ];
            }
            r = this.performAction.apply(yyval, [
                yytext,
                yyleng,
                yylineno,
                sharedState.yy,
                action[1],
                vstack,
                lstack
            ].concat(args));
            if (typeof r !== 'undefined') {
                return r;
            }
            if (len) {
                stack = stack.slice(0, -1 * len * 2);
                vstack = vstack.slice(0, -1 * len);
                lstack = lstack.slice(0, -1 * len);
            }
            stack.push(this.productions_[action[1]][0]);
            vstack.push(yyval.$);
            lstack.push(yyval._$);
            newState = table[stack[stack.length - 2]][stack[stack.length - 1]];
            stack.push(newState);
            break;
        case 3:
            return true;
        }
    }
    return true;
}};

function Parser () {
  this.yy = {};
}
Parser.prototype = parser;parser.Parser = Parser;
return new Parser;
})();


if (typeof require !== 'undefined' && typeof exports !== 'undefined') {
exports.parser = parser;
exports.Parser = parser.Parser;
exports.parse = function () { return parser.parse.apply(parser, arguments); };
exports.main = function commonjsMain(args) {
    if (!args[1]) {
        console.log('Usage: '+args[0]+' FILE');
        process.exit(1);
    }
    var source = require('fs').readFileSync(require('path').normalize(args[1]), "utf8");
    return exports.parser.parse(source);
};
if (typeof module !== 'undefined' && require.main === module) {
  exports.main(process.argv.slice(1));
}
}