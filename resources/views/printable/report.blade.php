<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>replit</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Zain:wght@200;300;400;700;800;900&display=swap" rel="stylesheet">
  {{-- <link href="style.css" rel="stylesheet" type="text/css" /> --}}
  <style>
        html {
        height: 100%;
        width: 100%;
        font-family: 'Zain', sans-serif;
        }

        body {
        background: rgb(204, 204, 204);
        }

        page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        /* box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5); */
        }

        page[size="A4"] {
        width: 21cm;
        height: 29.7cm;
        }

        page[size="A4"][layout="landscape"] {
        width: 29.7cm;
        height: 21cm;
        }

        page[size="A3"] {
        width: 29.7cm;
        height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
        width: 42cm;
        height: 29.7cm;
        }

        page[size="A5"] {
        width: 14.8cm;
        height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
        width: 21cm;
        height: 14.8cm;
        }

        @media print {

        body,
        page {
            background: white;
            margin: 0;
            box-shadow: 0;
        }
        }

        div.logo {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px;
        }

        div.header {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        padding-left: 50px;
        padding-right: 50px;
        }

        div.header .title,
        div.header .info{
        margin: 0; 
        }

        div.header .title{
        margin-bottom: 15px;
        }

        div.header .info{
        font-size: 18px;
        }

        div.header > * {
        flex: 1;  
        }

        div.body {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        padding: 50px;
        }

        div.body .info{
        margin: 0; 
        }

        div.body .info{
        font-size: 18px;
        }
  </style>
</head>

<body>
  <page size="A4">
    <div class="logo">
      <img src="https://hr.anseebeauty.com/storage/site_images/site_logo.png" alt="LOGO">
    </div>
    <div class="header">
      <div class="col-6">
        <h1 class="title">Leave Request</h1>
        <p class="info"><b>Name: </b>{{ucwords($leave->user->first_name)}} {{ucwords($leave->user->last_name)}}</p>
        <p class="info"><b>Role: </b>{{$leave->user->roles->first()->title ?? 'No Role'}}</p>
        <p class="info"><b>Phone Number: </b>{{$leave->user->profile->phone}} {{$leave->user->profile->mobile}}</p>
      </div>
      <div class="col-6">
        <h1 class="title" style="visibility:hidden;">#</h1>
        <p class="info"><b>Request id: </b>#{{$leave->id}}</p>
        <p class="info"><b>Employee id: </b>#{{$leave->user->id}}</p>
      </div>
    </div>
    <hr>
    <div class="body">
        <p class="info">I kindly request you to grant me a {{$totalLeaveHours}} - hour leave as follows:</p>
        <br>
        <p class="info"><b>From: </b>{{ date('h:i:s', strtotime($leave->from)) }}</p>
        <p class="info"><b>To: </b>{{ date('h:i:s', strtotime($leave->to)) }}</p>
        <p class="info"><b>Duration: </b>{{$totalLeaveHours}} Hours</p>
        <br>
        <p class="info">This is for the following reasons:</p>
        <p class="info">{{$leave->reason}}</p>
        <br>
        <p class="info">And Yours sincerely ,,,,</p>
        <p class="info"><b>Date: </b>{{ date('j M Y', strtotime($leave->created_at)) }}</p>
        <br>
        {{-- <p class="info"><b>Last vacation was on: </b>5 to 8</p>
        <p class="info"><b>Duration: </b>5</p> --}}
    </div>
    <br>
    <br>
    <br>
    <div class="header">
      <div class="col-6">
        <!-- <img src="https://hr.anseebeauty.com/storage/site_images/site_logo.png" alt="LOGO"> -->
        <p class="info"><b>Employer Sign: </b>...............................................................</p>
      </div>
      <div class="col-6">
        <!-- <img src="https://hr.anseebeauty.com/storage/site_images/site_logo.png" alt="LOGO"> -->
        <p class="info"><b>Employee Sign: </b>...............................................................</p>
      </div>
    </div>
  </page>
  <script src="script.js"></script>
</body>

</html>