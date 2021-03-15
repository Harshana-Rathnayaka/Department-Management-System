$(document).ready(function () {
  var timestamp = new Date();
  sessionStorage.setItem("lastTimestamp", timestamp);

  function timeChecker() {
    setInterval(function () {
      var storedTimestamp = sessionStorage.getItem("lastTimestamp");
      timeCompare(storedTimestamp);
    }, 3000);
  }

  function timeCompare(timeString) {
    var currentTime = new Date();
    var pastTime = new Date(timeString);
    var timeDifference = currentTime - pastTime;
    var minutesPassed = Math.floor(timeDifference / 60000);

    if (minutesPassed > 30) {
      sessionStorage.removeItem("lastTimestamp");
      window.location = "../logout.php?logout";
      return false;
    } else {
      console.log(
        currentTime +
          " - " +
          pastTime +
          " - " +
          minutesPassed +
          " Minutes Passed"
      );
    }
  }

  $(document).mousemove(function () {
    timestamp = new Date();
    sessionStorage.setItem("lastTimestamp", timestamp);
  });

  timeChecker();
});
