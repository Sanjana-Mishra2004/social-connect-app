// for preview the post
var input = document.getElementById("select_post_img");

input.addEventListener("change", preview);

function preview() {
  var fileobject = this.files[0];
  var filereader = new FileReader();

  filereader.readAsDataURL(fileobject);

  filereader.onload = function () {
    var image_src = filereader.result;
    var image = document.getElementById("post_img");
    image.setAttribute("src", image_src);
    image.setAttribute("style", "display:");
  };
}

//to follow the user
$(".followbtn").click(function () {
  var user_id_v = $(this).data("user-id");
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "assets/php/ajax.php?follow",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      if (response.status) {
        // $(button).data('user-id', 0);
        $(button).text("Following");
        $(button).closest(".follow-suggestion").remove();
      } else {
        $(button).attr("disabled", false);
        alert("Something is wrong , Try again after sometime");
      }
    },
  });
});

//to unfollow the user
$(".unfollowbtn").click(function () {
  var user_id_v = $(this).data("user-id");
  var button = this;
  $(button).attr("disabled", true);

  $.ajax({
    url: "assets/php/ajax.php?unfollow",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      if (response.status) {
        $(button).data("user-id", 0);
        $(button).text("Unfollowed");
        // $(button).closest('.follow-suggestion').remove();
      } else {
        $(button).attr("disabled", false);
        alert("Something is wrong , Try again after sometime");
      }
    },
  });
});

//to like the post
$(".like_btn").click(function () {
  var post_id_v = $(this).data("post-id");
  var button = this;
  $(button).attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?like",
    method: "post",
    dataType: "json",
    data: { post_id: post_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).attr("disabled", false);
        $(button).hide();
        $(button).siblings(".unlike_btn").show();
        $("#likecount" + post_id_v).text(
          $("#likecount" + post_id_v).text() - -1
        );
        location.reload();
      } else {
        $(button).attr("disabled", false);
        alert("Something is wrong , Try again after sometime");
      }
    },
  });
});

//to unlike the post
$(".unlike_btn").click(function () {
  var post_id_v = $(this).data("post-id");
  var button = this;
  $(button).attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?unlike",
    method: "post",
    dataType: "json",
    data: { post_id: post_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(button).attr("disabled", false);
        $(button).hide();
        $(button).siblings(".like_btn").show();
        $("#likecount" + post_id_v).text(
          $("#likecount" + post_id_v).text() - 1
        );
        location.reload();
      } else {
        $(button).attr("disabled", false);
        alert("Something is wrong , Try again after sometime");
      }
    },
  });
});

//to add comment
$(".add-comment").click(function () {
  var button = this;
  var comment_v = $(button).siblings(".comment-input").val();

  if (comment_v == " ") {
    return 0;
  }
  var post_id_v = $(this).data("post-id");
  var cs = $(this).data("cs");
  var page = $(this).data("page");

  $(button).attr("disabled", true);
  $(button).siblings(".comment-input").attr("disabled", true);
  $.ajax({
    url: "assets/php/ajax.php?addcomment",
    method: "post",
    dataType: "json",
    data: { post_id: post_id_v, comment: comment_v },
    success: function (response) {
      // console.log(response);
      if (response.status) {
        $(button).attr("disabled", false);
        $(button).siblings(".comment-input").attr("disabled", false);
        $(button).siblings(".comment-input").val("");
        $("#" + cs).prepend(response.comment);
        $(".nce").hide();
        if (page == "home") {
          location.reload();
        }
      } else {
        $(button).attr("disabled", false);
        $(button).siblings(".comment-input").attr("disabled", false);
        alert("Something is wrong , Try again after sometime");
      }
    },
  });
});

// for searching
var sra = false;

$("#search").focus(function () {
  $("#search_result").show();
});

$("#close_search").click(function () {
  $("#search_result").hide();
});

$("#search").keyup(function () {
  var keyword_v = $(this).val();

  $.ajax({
    url: "assets/php/ajax.php?search",
    method: "post",
    dataType: "json",
    data: { keyword: keyword_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        $("#sra").html(response.users);
      } else {
        $("#sra").html('<p class="text-center text-muted">No User Found!</p>');
      }
    },
  });
});

// fetching jquery timeago method
jQuery(document).ready(function () {
  jQuery("time.timeago").timeago();
});

// for notification count
$("#show_not").click(function () {
  $.ajax({
    url: "assets/php/ajax.php?notread",
    method: "post",
    dataType: "json",
    success: function (response) {
      console.log(response);
      if (response.status) {
        $(".un-count").hide();
        // if (response.read_status == 1) {
        //     $(".not").hide();

        // }
      }
    },
  });
});

// to unblock
$(".unblockbtn").click(function () {
  var user_id_v = $(this).data("user-id");
  var button = this;
  $(button).attr("disabled", true);
  console.log("clicked");
  $.ajax({
    url: "assets/php/ajax.php?unblock",
    method: "post",
    dataType: "json",
    data: { user_id: user_id_v },
    success: function (response) {
      console.log(response);
      if (response.status) {
        location.reload();
      } else {
        $(button).attr("disabled", false);
        alert("Something is wrong , Try again after sometime");
      }
    },
  });
});

// to get chatlist
var chatter_id_v = 0;

function popchat(user_id) {
  $("#chatter_uname").text("loading...");
  $("#chatter_fname").text("");
  $("#chatter_img").attr("src", "assets/images/profile/defaultprofile.jpg");
  $("#user_chat").html(
    '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div></div>'
  );

  chatter_id_v = user_id;

  // Mark messages as read when opening chat
  $.ajax({
    url: "assets/php/ajax.php?updateReadStatus",
    method: "POST",
    data: { user_id: user_id },
    success: function (response) {
      if (response.status) {
        syncMsg(); // Refresh messages after marking as read
      }
    },
  });
}

$("#sendmsg").click(function () {
  var user_id = chatter_id_v;
  var msg = $("#msginput").val();
  if (!msg) return;
  $("#sendmsg").attr("disabled", true);
  $("#msginput").attr("disabled", true);

  $.ajax({
    url: "assets/php/ajax.php?sendMessage",
    method: "post",
    dataType: "json",
    data: { user_id: user_id, msg: msg },
    success: function (response) {
      if (response.status) {
        $("#msginput").val("");
      } else {
        alert("Message failed to send! Try again.");
      }
    },
    complete: function () {
      $("#sendmsg").attr("disabled", false);
      $("#msginput").attr("disabled", false);
    },
  });
});

function syncMsg() {
  $.ajax({
    url: "assets/php/ajax.php?getMessage",
    method: "post",
    dataType: "json",
    data: { chatter_id: chatter_id_v },
    success: function (response) {
      //   console.log(response);

      $("#chatlist").html(response.chatlist);
      if (response.newmsg == 0) {
        $("#msg_count").hide();
      } else {
        $("#msg_count").show();
        $("#msg_count").html("<small>" + response.newmsg + "</small>");
        sessionStorage.setItem("unreadMsgCount", response.newmsg); // Store unread count
      }

      if (response.blocked) {
        $("#msg_sender").hide();
        $("#blockerror").show();
      } else {
        $("#msg_sender").show();
        $("#blockerror").hide();
      }

      if (chatter_id_v != 0) {
        $("#user_chat").html(response.chat.msgs);
        $("#chatter_uname").text(response.chat.userdata.username);
        $("#clink").attr('href', '?user=' + response.chat.userdata.username);
        $("#chatter_fname").text(
          response.chat.userdata.fname + " " + response.chat.userdata.lname
        );
        $("#chatter_img").attr(
          "src",
          "assets/images/profile/" + response.chat.userdata.profile_img
        );
        // console.log(response.newmsg);

       
      }
    },
  });
}

// Restore unread messages when page loads
$(document).ready(function () {
  let unreadCount = sessionStorage.getItem("unreadMsgCount");
  if (unreadCount && unreadCount > 0) {
    $("#msg_count").show();
    $("#msg_count").html("<small>" + unreadCount + "</small>");
  }
});

syncMsg();

setInterval(() => {
  syncMsg();
}, 1000);
