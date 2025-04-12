<div class="card card-primary col-12">
    <div class="card-header">
        <h5 class="card-title">Generate Date wise Report</h5>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="mb-3">
                <label for="exampleDataList2" class="form-label">Select Report Type</label>
                <input class="form-control" list="datalistOptions2" id="exampleDataList2" name="type2" placeholder="Type to search...">

                <datalist id="datalistOptions2">
                    <option value="Active Users">
                    <option value="Inactive Users">
                    <option value="New Users">
                </datalist>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label for="fromDate" class="form-label">Select From Date</label>
                    <input class="form-control" type="date" id="fromDate" name="fromDate" placeholder="Enter date...">

                </div>
                <div class="col-md-5">
                    <label for="toDate" class="form-label">Select To Date</label>
                    <input class="form-control" type="date" id="toDate" name="toDate" placeholder="Enter date...">

                </div>

            </div>
            <div>
                <h4 class="text-muted">OR</h4>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label for="toDate" class="form-label">Enter Year</label>
                    <input class="form-control" type="text" id="year" name="year" placeholder="Enter Year...">

                </div>
                <div class="col-md-5">
                    <label for="month" class="form-label">Select Month</label>
                    <select id="month" name="month" class="form-select col-12">
                        <option value="Jan" selected>January</option>
                        <option value="Feb">February</option>
                        <option value="Mar">March</option>
                        <option value="Apr">April</option>
                        <option value="May">May</option>
                        <option value="Jun">June</option>
                        <option value="Jul">July</option>
                        <option value="Aug">August</option>
                        <option value="Sep">September</option>
                        <option value="Oct">October</option>
                        <option value="Nov">November</option>
                        <option value="Dec">December</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="sbt2">Submit</button>

        </form>
    </div>
</div>

<?php
if (isset($_POST['sbt2'])) {
    $type = trim($_POST['type2']);
    $from = trim($_POST['fromDate']);
    $to = trim($_POST['toDate']);
    $year = trim($_POST['year']);
    $month = trim($_POST['month']);
    $errors = []; // Store errors in an array

    if (empty($type)) {
        $errors[] = "Please select a report type.";
    }

    if ((empty($from) || empty($to)) && (empty($year) || empty($month))) {
        $errors[] = "Please provide either a date range or year & month.";
    }

    // Display errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="card w-60 m-auto">
                <div class="card-body bg-danger">
                    <p class="card-text ">'.$error.'</p>
                </div>
            </div>';
        }
    } else {
        // Process the form if there are no errors
        if (!empty($from) && !empty($to)) {
            $users = getUsersByDateRange($type, $from, $to);
        } elseif (!empty($year) && !empty($month)) {
            $users = getUsersByYearMonth($type, $year, $month);
        }
        displayUsers($users);
    }
}
?>
