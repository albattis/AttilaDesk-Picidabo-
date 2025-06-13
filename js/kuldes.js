
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.getElementById('close');
    const reopenBtn = document.getElementById('reopen');
    const taskValueElement = document.getElementById('taskvalue');
    let remainingTime = document.getElementById('remainingTime');
    const updateStatusBtn = document.getElementById('updateStatus');
    const taskStatusElement = document.getElementById('taskStatus');
    updateProgressBar(taskProgress);



    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            if (confirm('Biztosan be akarja fejezni a feladatot?')) {
                var xhr = new XMLHttpRequest();
                var formData = new FormData();
                formData.append('close', true);
                xhr.open('POST', 'index.php?controller=Task&action=view&id=' + taskId, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const alap = document.getElementById("alapanyag");
                        if (alap) alap.hidden = true;
                        taskValueElement.innerHTML = 'A feladat lezárva.';
                        closeBtn.hidden = true;
                        reopenBtn.hidden = false;
                        remainingTime.innerHTML = 'Feladat befejezve.';
                        updateProgressBar("100");
                    } else {
                        console.error('Hiba történt: ' + xhr.statusText);
                        alert('Hiba történt a feladat lezárása közben. Kérlek, próbáld újra.');
                    }
                };
                xhr.send(formData);
            } else {
                console.log('Feladat befejezése megszakítva.');
            }
        });
    } else {
        console.error('Nem található a #close elem.');
    }
    if (updateStatusBtn)
    {
        updateStatusBtn.addEventListener('click', function() {
            const newStatus = taskStatusElement.value;
            var xhr = new XMLHttpRequest();
            var formData = new FormData();
            formData.append('status', newStatus);
            xhr.open('POST', 'index.php?controller=Task&action=view&id=' + taskId, true);
            xhr.onload = function()
            { if (xhr.status === 200)
            {
                console.log(taskProgress);
                updateProgressBar(taskProgress);
                taskValueElement.innerHTML = 'A feladat státusza: ' + newStatus; console.log('Feladat státusza frissítve:', newStatus);
                switch (newStatus)
                {
                    case 'felvett':
                        taskProgress = 10;
                        break;
                    case 'nyomtatva':
                        taskProgress = 50;
                        break;
                    case 'ertesitve':
                        taskProgress = 75;
                        break;
                    case 'befejezett':
                        taskProgress = 100;
                        break;
                    default: taskProgress = 0;
                }
                console.log(taskProgress);
                updateProgressBar(taskProgress);
            } else
            { console.error('Hiba történt: ' + xhr.statusText);
                alert('Hiba történt a státusz frissítése közben. Kérlek, próbáld újra.');
            }
            };
            xhr.send(formData);

        });

    } else
    {
        console.error('Nem található a #updateStatus elem.');
    }

    if (reopenBtn) {
        reopenBtn.addEventListener('click', function() {
            if (confirm('Biztosan vissza akarja nyitni a feladatot?')) {
                var xhr = new XMLHttpRequest();
                var formData = new FormData();
                formData.append('reopen', true);
                xhr.open('POST', 'index.php?controller=Task&action=view&id=' + taskId, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {


                        const alap = document.getElementById("alapanyag");
                        if (alap) alap.hidden = false;
                        taskValueElement.innerHTML = 'A feladat még aktiv.';
                        closeBtn.hidden = false; // Újra megjelenítjük a "Feladat lezárása" gombot
                        reopenBtn.hidden = true; // Elrejtjük a "Feladat visszanyitása" gombot
                        remainingTime.innerHTML = 'Fentmaradó idő számítása...'; // vagy tetszőleges üzenet
                        updateProgressBar('10');

                    } else {
                        console.error('Hiba történt: ' + xhr.statusText);
                        alert('Hiba történt a feladat visszanyitása közben. Kérlek, próbáld újra.');
                    }
                };
                xhr.send(formData);
            } else {
                console.log('Feladat visszanyitása megszakítva.');
            }
        });
    } else {
        console.error('Nem található a #reopen elem.');
    }
});

function updateProgressBar(progress)
{
    const progressBarFill = document.getElementById('progress-bar-fill');
    const progressBarText = document.getElementById('progress-bar-text');
    progressBarFill.style.width = progress + '%';
    progressBarText.textContent = progress + '%';
    if (progress >= 100)
    {
        progressBarFill.style.backgroundColor = '#76c7c0';
        progressBarText.textContent = 'Kész!';
    }
}


