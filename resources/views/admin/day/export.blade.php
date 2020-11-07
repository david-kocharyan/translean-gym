<!DOCTYPE html>
<html>
<head>
    <title>Invoice Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div  id="cont">
    <div class="report-head">
        <div class="logo-parent"></div>
        <div class="info-parent">
            <div class="name"></div>
            <div class="date-pdf">
                <span class="date-pdf-month"></span> 
                <span class="date-pdf-day"></span>, 
                <span class="date-pdf-year"></span>
            </div>
            <div class="week-day"></div>
        </div>
    </div>
    <div class ="container-pdf">

        <div class="timings">
            <div> <span> 00:00 </span> AM </div>
            <div> 00:30 </div>
            <div> <span> 1:00 </span> AM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span> AM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span> AM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span> AM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span> AM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span> AM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span> AM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span> AM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span> AM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>AM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>AM </div>
            <div> 11:30 </div>
            <div> <span> 12:00 </span>PM </div>
            <div> 12:30 </div>
            <div> <span> 1:00 </span>PM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span>PM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span>PM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span>PM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span>PM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span>PM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span>PM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span>PM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span>PM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>PM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>PM </div>
            <div> 11:30 </div>
        </div>

        <div class="days" id="actions-pdf">
        </div>
        <div class="water" id="water-pdf">
        </div>
        <div class="meal" id="meal-pdf">
        </div>

        <div class="timings right-timing">
            <div> <span> 00:00 </span> AM </div>
            <div> 00:30 </div>
            <div> <span> 1:00 </span> AM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span> AM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span> AM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span> AM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span> AM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span> AM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span> AM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span> AM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span> AM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>AM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>AM </div>
            <div> 11:30 </div>
            <div> <span> 12:00 </span>PM </div>
            <div> 12:30 </div>
            <div> <span> 1:00 </span>PM </div>
            <div> 1:30 </div>
            <div> <span> 2:00 </span>PM </div>
            <div> 2:30 </div>
            <div> <span> 3:00 </span>PM </div>
            <div> 3:30 </div>
            <div> <span> 4:00 </span>PM </div>
            <div> 4:30 </div>
            <div> <span> 5:00 </span>PM </div>
            <div> 5:30 </div>
            <div> <span> 6:00 </span>PM </div>
            <div> 6:30 </div>
            <div> <span> 7:00 </span>PM </div>
            <div> 7:30 </div>
            <div> <span> 8:00 </span>PM </div>
            <div> 8:30 </div>
            <div> <span> 9:00 </span>PM </div>
            <div> 9:30 </div>
            <div> <span> 10:00 </span>PM </div>
            <div> 10:30 </div>
            <div> <span> 11:00 </span>PM </div>
            <div> 11:30 </div>
        
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
    let userInfo = '<?php echo $user ?>';
    userInfo = JSON.parse(userInfo)
    $('.name').html(userInfo.name)

</script>
</body>
</html>
