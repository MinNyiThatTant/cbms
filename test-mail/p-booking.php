<?php

if (($_GET)) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        // Updated SQL query to join with specialties table
        $sqlmain = "SELECT schedule.*, doctor.docname, doctor.docemail, specialties.sname 
                    FROM schedule 
                    INNER JOIN doctor ON schedule.docid = doctor.docid 
                    INNER JOIN specialties ON doctor.docid = specialties.id 
                    WHERE schedule.scheduleid = ? 
                    ORDER BY schedule.scheduledate DESC";
        
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        $scheduleid = $row["scheduleid"];
        $title = $row["title"];
        $docname = $row["docname"];
        $docemail = $row["docemail"];
        $scheduledate = $row["scheduledate"];
        $scheduletime = $row["scheduletime"];
        $specialtyName = $row["sname"]; // Fetching the specialty name

        $sql2 = "SELECT * FROM appointment WHERE scheduleid = $id";
        $result12 = $database->query($sql2);
        $apponum = ($result12->num_rows) + 1;

        echo '
        <form action="booking-complete.php" method="post">
            <input type="hidden" name="scheduleid" value="' . $scheduleid . '" >
            <input type="hidden" name="apponum" value="' . $apponum . '" >
            <input type="hidden" name="date" value="' . $today . '" >
        ';

        echo '
        <td style="width: 50%;" rowspan="2">
            <div class="dashboard-items search-items">
                <div style="width:100%">
                    <div class="h1-search" style="font-size:25px;">
                        Session Details
                    </div><br><br>
                    <div class="h3-search" style="font-size:18px;line-height:30px">
                        ဒေါက်တာအမည် :  &nbsp;&nbsp;<b>' . $docname . '</b><br>
                        ဒေါက်တာ Email:  &nbsp;&nbsp;<b>' . $docemail . '</b><br>
                        ဒေါက်တာ အထူးပြုမှု: &nbsp;&nbsp;<b>' . $specialtyName . '</b><br> <!-- Displaying the specialty name -->
                    </div>
                    <div class="h3-search" style="font-size:18px;">
                    </div><br>
                    <div class="h3-search" style="font-size:18px;">
                        Session Title/ကုသမည့်အကြောင်းအရာ: ' . $title . '<br>
                        Session Scheduled Date/ကုသမည့်ရက်စွဲ: ' . $scheduledate . '<br>
                        Session Starts/ စတင်ကုသမည့်အချိန် : ' . $scheduletime . '<br>
                    </div>
                    <br>
                </div>
            </div>
        </td>
        ';
    }
}
