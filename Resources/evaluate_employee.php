<form method="POST" action="app/submit_evaluation.php">
    <input type="hidden" name="evaluator_id" value="1"> <!-- Evaluator ID -->
    <input type="hidden" name="user_id" value="1"> <!-- Employee ID -->
    <input type="hidden" name="kpi_id" value="1"> <!-- KPI ID -->

    <label for="score">Score:</label>
    <input type="number" name="score" id="score" required>

    <label for="feedback">Feedback:</label>
    <textarea name="feedback" id="feedback" required></textarea>
    
    <button type="submit">Submit Evaluation</button>
</form>
