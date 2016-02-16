/**
 * JS file for JSLog extra
 *
 * Copyright 2016 by Andreas Bilz <anti@herooutoftime.com>
 * Created on 02-15-2016
 *
 * JSLog is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * JSLog is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * JSLog; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * @package jslog
 */

console.log('HELLO JS LOG!');
var Errors = [];
Ext.onReady(function() {
  window.onerror = function (msg, jsUrl, line)
  {
    // MGR Context
    function get_browser_info(){
      var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
      if(/trident/i.test(M[1])){
          tem=/\brv[ :]+(\d+)/g.exec(ua) || [];
          return {name:'IE',version:(tem[1]||'')};
          }
      if(M[1]==='Chrome'){
          tem=ua.match(/\bOPR\/(\d+)/)
          if(tem!=null)   {return {name:'Opera', version:tem[1]};}
          }
      M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
      if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
      return {
        name: M[0],
        version: M[1]
      };
    }
    var browser = get_browser_info();

    var data = {
      action: 'log',
      msg: msg,
      jsUrl: jsUrl,
      line: line,
      browser: browser,
      browserUrl: window.location
    };

    Ext.Ajax.request({
      url: JSLog.config.connectorUrl,
      jsonData: data,

      success: function(response, opts){
        // If the response is JSON, you have to decode it
        // var obj = Ext.decode(response.responseText);
        // Ext.fly('some_div').update('Success!');
      },
      failure: function(response, opts) {
        // Ext.fly('some_div').update('Fail!');
      },
      // callback: function(options,success,response){
      //   // use this if you need to perform your own success/failure checking
      // }
    });
  };

  // WEB Context or any other frontend context
  // THIS COULD HANDLE JS ERROR WITHOUT JQUERY NEEDED
  // var http = new XMLHttpRequest();
  // var url = JSLog.config.connectorUrl;
  // var params = "action=log";
  // http.open("POST", url, true);
  //
  // //Send the proper header information along with the request
  // http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // http.setRequestHeader("Content-length", params.length);
  // http.setRequestHeader("Connection", "close");
  //
  // http.onreadystatechange = function() {//Call a function when the state changes.
  //     if(http.readyState == 4 && http.status == 200) {
  //         alert(http.responseText);
  //     }
  // }
  // http.send(params);
});

// Test error
// test = test;
