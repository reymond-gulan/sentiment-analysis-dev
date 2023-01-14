@if(count($data['comments']) > 0)
<?php
    $dataPoints = array();

    foreach($data['value'] as $row) {
        array_push($dataPoints, array("label"=> date('M j, Y', strtotime($row->created_at)), "y"=> $row->count));
    }

    $dataPoints2 = array( 
        array("label"=>"Neutral", "y"=> number_format($data['neutral'],2)),
        array("label"=>"Negative", "y"=> number_format($data['negative'],2)),
        array("label"=>"Positive", "y"=> number_format($data['positive'],2)),
    )
?>
<div class="row">
    <div class="container">
        <div class="row my-4">
            <div class="col-sm-6 shadow-sm border rounded px-2 p-0" style="height:350px;overflow-x:hidden;overflow-y:scroll;">
                <div class="container">
                    <center><b>Comments</b></center>
                    <ul class="list-group">
                    @foreach($data['comments'] as $comment)
                        <li class="list-group-item small bold">
                            <small>
                            <span class="bg-danger border-0 p-0 rounded rounded-3 px-2 small py-1 text-white">
                                - {{$comment->negative}}    
                            </span>
                            &nbsp;
                            <span class="bg-success border-0 p-0 rounded rounded-3 px-2 small py-1 text-white">
                                + {{$comment->positive}}    
                            </span>
                            &nbsp;
                            <span class="bg-primary border-0 p-0 rounded rounded-3 px-2 small py-1 text-white ml-1">
                                ~ {{$comment->neutral}}    
                            </span>
                            <p class="my-1">{{$comment->comment}}</p>
                            </small>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="pie" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
        <div class="row">
            <div class="container border p-5 shadow-lg rounded rounded-5">
                <div id="column" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () {
	 
    var chart = new CanvasJS.Chart("column", {
        title:{
                text: "Number of Comments by Date"              
            },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK) ?>
        }]
    });
    chart.render();

    var chart2 = new CanvasJS.Chart("pie", {
        title:{
                text: "Sentiment Analysis"              
            },
        data: [{
            type: "pie",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK) ?>
        }]
    });
    chart2.render();
    
});
</script>
@else
<div class="row justify-content-center mt-5">
    <div class="col-sm-12 p-0">
        <div class="alert alert-success">
        <center>
            No record found.
        </center>
        </div>
    </div>
</div>
@endif