$(document).ready(function() {
    // Load chat history on page load
    loadChat();

    // Send user message when send button is clicked
    $("#send-message").on("click", function() {
        var message = $("#user-message").val();
        if (message != "") {
            sendMessage(message);
            $("#user-message").val("");
        }
    });

    // Send user message when enter key is pressed
    $("#user-message").on("keyup", function(event) {
        if (event.keyCode === 13) {
            $("#send-message").click();
        }
    });
});

function loadChat() {
    $.ajax({
        url: "chat.php",
        type: "GET",
        success: function(data) {
            $(".messages").html(data);
            scrollToBottom();
        }
    });
}

function sendMessage(message) {
    $.ajax({
        url: "send.php",
        type: "POST",
        data: { message: message },
        success: function(data) {
            loadChat();
        }
    });
}

function scrollToBottom() {
    var height = $(".messages")[0].scrollHeight;
    $(".messages").scrollTop(height);
}