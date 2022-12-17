const urlParams = new URLSearchParams(window.location.search);

let notificationCount = 0;

$(function() {
    dataTable = $("#table-topic-data").DataTable({
        order: [[0, "asc"]],
        rowReorder: true
    });
});

function showDataTable(topic) {
    $.blockUI({
        message: $('#blockUILoader')
    });

    $.ajax({
        method: "POST",
        url: "../php/ajax.php",
        data: {
            action: "getTopicData",
            topic: topic
        }
    }).done(function(data) {
        dataTable.clear().draw();

        let json = JSON.parse(data);

        for (var i = 0; i < json.cantons.length; i++){
            dataTable.row.add([json.cantons[i].rang, json.cantons[i].kuerzel, json.cantons[i].kennzahl]).draw(false);
        }

        switch (topic) {
            case "e":
                $("#topicDataTitle").html("Topic: Education");
                $("#value-description").html("Amount of schools");
                break;
            case "j":
                $("#topicDataTitle").html("Topic: Job offer");
                $("#value-description").html("Amount of jobs");
                break;
            case "s":
                $("#topicDataTitle").html("Topic: Safety");
                $("#value-description").html("Amount of crimes");
                break;
            case "c":
                $("#topicDataTitle").html("Topic: Living costs");
                $("#value-description").html("Average cost of living");
                break;
        }
        
        $("#section-details-table").show();

        $.unblockUI();
    });
}

function showNotification(nachricht, success) {
    let notiCount = (notificationCount += 1);
    let notification;

    if(success) {
        notification = `<div class="bg-success notificationContent fadeNotification" data-notificationID="${notiCount}">
                            <h4 class="notificationTitle">Success</h4>
                            <p class="notificationText">${nachricht}</p>
                        </div>`
    } else {
        notification = `<div class="bg-danger notificationContent fadeNotification" data-notificationID="${notiCount}">
                            <h4 class="notificationTitle">Error</h4>
                            <p class="notificationText">${nachricht}</p>
                        </div>`
    }

    let newElm = document.createElement("div");
    newElm.innerHTML = notification;

    $("#notificationContainer").append(newElm.firstChild);

    setTimeout(function() {
        $("[data-notificationID='" + notiCount + "']").remove();
    }, 4000);
}