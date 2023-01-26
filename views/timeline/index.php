<?php

// use yii\helpers\Html;
// use yii\helpers\Url;
// use yii\bootstrap5\Modal;
// use kartik\dynagrid\DynaGrid;
// use kartik\grid\GridView;
// use yii\widgets\ListView;

$this->title = 'Timeline Product';

?>

<?php include 'style-timeline.php'; ?>

<div class="card border-info">
    <div class="card-header bg-warning text-dark">
        <div class="float-end">

        </div>
        <h5 class="m-0"></h5>
        <h3 class="panel-title">
            <i class="fa fa-book"></i> Timeline Tracking
        </h3>
        <div class="clearfix"></div>
    </div>

</div>

<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cari Faktur" title="Faktur">
<table id="tbtimeline" class="table table-striped" data-search="true">
    <thead>
        <tr>
            <th>No. faktur</th>
            <th>Timeline</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>asdaasdfasdfasdfsdas</td>
            <td>
                <section>
                    <div class="rt-container">
                        <div class="col-rt-12">
                            <div class="Scriptcontent">
                                <ul class="timeline">
                                    <li data-year="<?php echo $divisiAtas['data'][0]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][1]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][2]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][3]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][6]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][4]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][5]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="rt-container">
                        <div class="col-rt-12">
                            <div class="Scriptcontent">
                                <ul class="timeline">
                                    <li data-year="<?php echo $divisiBawah['data'][0]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiBawah['data'][1]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiBawah['data'][2]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </td>
        </tr>
        <tr>
            <td>5756757</td>
            <td>
                <section>
                    <div class="rt-container">
                        <div class="col-rt-12">
                            <div class="Scriptcontent">
                                <ul class="timeline">
                                    <li data-year="<?php echo $divisiAtas['data'][0]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][1]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][2]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][3]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][6]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][4]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiAtas['data'][5]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="rt-container">
                        <div class="col-rt-12">
                            <div class="Scriptcontent">
                                <ul class="timeline">
                                    <li data-year="<?php echo $divisiBawah['data'][0]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiBawah['data'][1]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                    <li data-year="<?php echo $divisiBawah['data'][2]; ?>" data-text="Start: 01/12/21  End: 10/12/21  By: Ikram"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </td>
        </tr>
    </tbody>
</table>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tbtimeline");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    $(document).ready(function() {

    });
</script>