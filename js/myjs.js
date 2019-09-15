$(function()
      {
      //on page load
      setTimeout("displaytime()", 1000);
      })
      function displaytime()
      {
      var dt = new Date();
      $('#idtime').html(dt.toLocaleTimeString());
      setTimeout("displaytime()", 1000);
      }