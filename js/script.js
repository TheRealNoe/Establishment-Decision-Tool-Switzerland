let notificationCount = 0;
let educationPointsOld = 25;
let jobPointsOld = 25;
let safetyPointsOld = 25;
let costPointsOld = 25;

$(function() {
    dataTable = $("#table-results").DataTable({
        order: [[1, "desc"]],
        rowReorder: true,
        columnDefs: [
            {
                targets: "no-sort",
                orderable: false
            }
        ]
    }).on('page.dt', function () {
        setTimeout(() => {
            drawMiniBarChart();
        }, 100);
    });


    $(".input-points").change(e => {
        validateInputs();
        let sum = countPoints();

        if(sum > 100) {
            showNotification("You can distribute a maximum of 100 points!", false);
            $("#input-education").val(educationPointsOld);
            $("#input-jobs").val(jobPointsOld);
            $("#input-safety").val(safetyPointsOld);
            $("#input-costs").val(costPointsOld);
            sum = parseInt(educationPointsOld) + parseInt(jobPointsOld) + parseInt(safetyPointsOld) + parseInt(costPointsOld);
            console.log(sum);
        } else {
            educationPointsOld = $("#input-education").val();
            jobPointsOld = $("#input-jobs").val();
            safetyPointsOld = $("#input-safety").val();
            costPointsOld = $("#input-costs").val();
        }
        $("#pointsToDistribute").html(sum <= 100 ? 100 - sum : 0);
    });

    $("#inputForm").submit(function(e) {
        e.preventDefault();

        if(countPoints() < 100) {
            showNotification("You have to distribute all the points!", false);
            return;
        }

        $.blockUI({
            message: $('#blockUILoader')
        });

        $.ajax({
            method: "POST",
            url: "php/ajax.php",
            data: {
                action: "getPointsPerCanton",
                educationPoints: $("#input-education").val(),
                jobPoints: $("#input-jobs").val(),
                safetyPoints: $("#input-safety").val(),
                costPoints: $("#input-costs").val()
            }
        }).done(function(data) {
            dataTable.clear().draw();

            let json = JSON.parse(data);

            for (var i = 0; i < json.cantons.length; i++){
                dataTable.row.add([
                    json.cantons[i].kuerzel,
                    Math.round(json.cantons[i].totalPoints * 100) + "%",
                    Math.round(json.cantons[i].educationPoints * 100) + "%",
                    Math.round(json.cantons[i].jobPoints * 100) + "%",
                    Math.round(json.cantons[i].safetyPoints * 100) + "%",
                    Math.round(json.cantons[i].costPoints * 100) + "%",
                    '<canvas class="minibarchart" width="100" height="50" data-educationPoints="'+json.cantons[i].educationPoints+'" data-jobPoints="'+json.cantons[i].jobPoints+'" data-safetyPoints="'+json.cantons[i].safetyPoints+'" data-costPoints="'+json.cantons[i].costPoints+'"></canvas>',
                    '<a class="btn text-white" style="padding: 10px; background-color: #3B71CA;" href="php/detail.php?canton=' + json.cantons[i].kuerzel + '" role="button"><i class="far fa-eye"></i></a>'
                ]).draw(false);
            }

            $("#container-table-results").show();

            drawMiniBarChart();

            $.unblockUI();

            showNotification("Points successfully calculated!", true);
        });
    });
});

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

function validateInputs() {
    $(".input-points").each(function () {
        $(this).val(Math.abs(parseInt($(this).val())));
    });
}

function countPoints() {
    let sum = 0;

    $(".input-points").each(function () {
        sum+= parseInt($(this).val());
    });

    return sum;
}

function drawMiniBarChart(){
    var minibarchart = document.getElementsByClassName("minibarchart");
    for (var i = 0; i < minibarchart.length; i++) {
        var chart = new Chart(minibarchart[i], {
            type: 'bar',
            data: {
                labels: ['Education', 'Jobs', 'Safety', 'Cost'],
                datasets: [{
                label: 'Points',
                data: [
                    Math.round(minibarchart[i].getAttribute('data-educationPoints')*100),
                    Math.round(minibarchart[i].getAttribute('data-jobPoints')*100),
                    Math.round(minibarchart[i].getAttribute('data-safetyPoints')*100),
                    Math.round(minibarchart[i].getAttribute('data-costPoints')*100)
                ],
                borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: { legend: { display: false }, },
                scales: {
                y: {
                    beginAtZero: true,
                    display: false
                },
                x: {
                    display: false
                }
                }
            }
        });
    }
}