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

function showChart(canton){
    const dataRang = {
        labels: ['Education', 'Job offer', 'Safety', 'Living costs'],
        datasets: [
            {
                label: "Average",
                backgroundColor: "#ff00e6",
                borderColor: "#ff00e6",
                data: [13.5, 13.5, 13.5, 13.5]
            },
        ]
    };

    $.blockUI({
        message: $('#blockUILoader')
    });
    $.ajax({
        method: "POST",
        url: "../php/ajax.php",
        data: {
            action: "getRanksPerCanton"
        }
    }).done(function(data) {
        const colors = ['#e6194B', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#42d4f4', '#f032e6', '#bfef45', '#fabed4', '#469990', '#dcbeff', '#9A6324', '#fffac8', '#800000', '#aaffc3', '#808000', '#ffd8b1', '#000075', '#a9a9a9', '#ffffff', '#000000',"#FF0000", "#FFFF00", "#00FF00", "#00FFFF", "#0000FF", "#FF00FF"]
        let json = JSON.parse(data);
        
        for (var i = 0; i < json.cantons.length; i++){
            if (json.cantons[i].kuerzel == canton){
                const newDataset = {
                    label: json.cantons[i].kuerzel,
                    backgroundColor: colors[i],
                    borderColor: colors[i],
                    data: [json.cantons[i].rangB, json.cantons[i].RangA, json.cantons[i].RangS, json.cantons[i].RangK],
                    hidden: false
                }
                dataRang.datasets.push(newDataset)
            }else{
                const newDataset = {
                    label: json.cantons[i].kuerzel,
                    backgroundColor: colors[i],
                    borderColor: colors[i],
                    data: [json.cantons[i].rangB, json.cantons[i].RangA, json.cantons[i].RangS, json.cantons[i].RangK],
                    hidden: true
                }
                dataRang.datasets.push(newDataset)
            }
            chart.update()
        }
    })

    $.unblockUI();

    const ctx = document.getElementById('chart');
    let chart = new Chart(ctx, {
        type: 'line',
        data: dataRang,
        options: {
        scales: {
            y: {
                title: {
                  display: true,
                  text: 'Rank'
                },
                display: true,
                beginAtZero: true
              }
        }
        }
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