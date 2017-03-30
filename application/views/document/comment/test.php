<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <title>jQuery Raty - A Star Rating Plugin</title>

    <script src="<?php echo base_url() ?>static/lib/raty/js/jquery.js"></script>
    <script src="<?php echo base_url() ?>static/lib/raty/js/jquery.raty.min.js"></script>

</head>
<body>


<div class="text">jQuery <b>Raty</b> is a plugin that generates a customizable star rating automatically.</div>

<div class="session">With default options:</div>
<div id="star"></div>

<div class="source">
    $('#star').raty();<br/><br/>

    &lt;div id="star"&gt;&lt;/div&gt;
</div>

<div class="session">Started with a score and read only value:</div>
<div id="fixed"></div>

3123213
        <div id="score_show" style="top:250px;">
        </div>

        <div id="cancel-custom" ></div>



</body>

<script type="text/javascript">
    $(function() {

        $('div#star').raty();

        $('div#fixed').raty({
            readOnly:	true,
            start:		2
        });


        $('div#score_show').raty({
            score: 3,
            start: 3.25,
            showHalf:  true,
            readOnly: true
        });
        $('div#cancel-custom').raty({
            cancelHint: 'remove my rating!',
            showCancel: false,
            onClick: function(score) {
                alert('score: ' + score);
            }
        });

    // $('#score_show').raty({ readOnly: true, score: 3 });

        /*$('div#custom').raty({
         scoreName:	'entity.score',
         number:		10
         });

         $('div#target').raty({
         hintList:	['a', '', null, 'd', '5'],
         starOn:		'medal-on.png',
         starOff:	'medal-off.png'
         });

         $('div#click').raty({
         onClick: function(score) {
         alert('score: ' + score);
         }
         });

         $('div#half').raty({
         start: 3.3,
         showHalf: true
         });

         $('div#cancel').raty({
         showCancel: true
         });

         $('div#cancel-custom').raty({
         cancelHint: 'remove my rating!',
         cancelPlace: 'right',
         showCancel: true,
         onClick: function(score) {
         alert('score: ' + score);
         }
         });*/

    });

</script>
</html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <title>jQuery Raty - A Star Rating Plugin</title>
    <script src="<?php echo base_url() ?>static/lib/raty/js/jquery.js"></script>
    <script src="<?php echo base_url() ?>static/lib/raty/js/jquery.raty.min.js"></script>

</head>
<body>

</body>
</html>