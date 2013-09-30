    addPost = function() {
        $.ajax({
            url: "/index.php",
            global: false,
            cache: false,
            type: "POST",
            data: {
                ajax    : 1,
                module  : "guestbook",
                action  : "add",
                name    : $("#add_name").val(),
                txt     : $("#add_txt").val()
            },
            success: function(response) {
                window.location.replace("/");
            }
        });
    };

    delPost = function(id) {
        $.ajax({
            url: "/index.php",
            global: false,
            cache: false,
            type: "POST",
            data: {
                ajax    : 1,
                module  : "guestbook",
                action  : "del",
                id      : id
            },
            success: function(response) {
                window.location.replace("/");
            }
        });
    };