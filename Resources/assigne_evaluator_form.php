<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Evaluator</title>
</head>
<body>
    <h2>Assign Evaluator to Employee</h2>
    <form action="../app/assign_evaluator.php" method="POST">
        <label for="evaluator">Evaluator:</label>
        <select name="evaluator_id" id="evaluator">
            <!-- Dynamically populated with PHP to list evaluators -->
            <?php
            // Assuming $evaluators contains evaluators fetched from the DB
            foreach ($evaluators as $evaluator) {
                echo "<option value='{$evaluator['id']}'>{$evaluator['name']}</option>";
            }
            ?>
        </select>

        <label for="employee">Employee:</label>
        <select name="employee_id" id="employee">
            <!-- Dynamically populated with PHP to list employees -->
            <?php
            // Assuming $employees contains employees fetched from the DB
            foreach ($employees as $employee) {
                echo "<option value='{$employee['id']}'>{$employee['name']}</option>";
            }
            ?>
        </select>

        <button type="submit">Assign Evaluator</button>
    </form>
</body>
</html>
