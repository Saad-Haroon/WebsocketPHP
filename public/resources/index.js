const socket = new WebSocket("ws://localhost:3001");

socket.addEventListener("open", function() {
    console.log("CONNECTED");
});

function addMessage(name, message) {
    const messageHTML = "<div class='message'><strong>" + name + ":</strong> " + message + "</div>";
    document.getElementById("chat").innerHTML += messageHTML
}

socket.addEventListener("message", function(e) {
    try
    {
        const message = JSON.parse(e.data);
        addMessage(message.name, message.message);
    }
    catch(e)
    {
        // Catch any errors
    }
});

document.getElementById("sendBtn").addEventListener("click", function() {
    const message = {
        name: document.getElementById("name").value,
        message: document.getElementById("message").value
    };
    socket.send(JSON.stringify(message));
    addMessage(message.name, message.message);
});
