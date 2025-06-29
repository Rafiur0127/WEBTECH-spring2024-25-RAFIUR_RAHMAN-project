document.querySelectorAll('.workout').forEach(item => {
    item.addEventListener('dragstart', function (e) {
        e.dataTransfer.setData('text/plain', this.dataset.name);
    });
});

document.querySelectorAll('.dropzone').forEach(zone => {
    zone.addEventListener('dragover', function (e) {
        e.preventDefault();
    });

    zone.addEventListener('drop', function (e) {
        e.preventDefault();
        const exercise = e.dataTransfer.getData('text/plain');
        const li = document.createElement('li');
        li.textContent = exercise;
        this.appendChild(li);
    });
});

function saveSchedule() {
    const schedule = {};
    document.querySelectorAll('.day').forEach(day => {
        const dayName = day.dataset.day;
        const exercises = [];
        day.querySelectorAll('li').forEach(li => {
            exercises.push(li.textContent);
        });
        schedule[dayName] = exercises;
    });

    fetch('?controller=workout&action=saveSchedule', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(schedule)
    })
    .then(res => res.text())
    .then(data => alert('✅ Saved!'))
    .catch(err => alert('❌ Failed to save'));
}
