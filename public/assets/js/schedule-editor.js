document.addEventListener("DOMContentLoaded", () => {
    const workouts = document.querySelectorAll(".draggable-workout");
    const cells = document.querySelectorAll(".schedule-cell");

    workouts.forEach(w => {
        w.addEventListener("dragstart", (e) => {
            e.dataTransfer.setData("text/plain", w.dataset.id);
        });
    });

    cells.forEach(cell => {
        cell.addEventListener("dragover", (e) => e.preventDefault());

        cell.addEventListener("drop", function (e) {
            e.preventDefault();
            const workoutId = e.dataTransfer.getData("text/plain");
            const week = this.dataset.week;
            const day = this.dataset.day;

            // Simple visual feedback
            this.classList.add("filled");
            this.innerText = "Workout ID: " + workoutId;

            // Save via AJAX
            $.post("/index.php?page=save_schedule", {
                user_id: 1,
                program_id: 1,
                workout_id: workoutId,
                week_number: week,
                day_of_week: day
            }, function (response) {
                console.log("Saved:", response);
            });
        });
    });
});
