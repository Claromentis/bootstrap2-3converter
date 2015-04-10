$(function () {

    var $out = $("#output");
    var $load = $("#loading");

    $("#convert").click(function ()
    {
        $out.html('...');
        $load.show();

        $.post(
            '../bs2-3/index.php',
            { src: $("#dir_path").val() },
            function (d)
            {
                var output = '';
                $out.html('');

                // notable files
                output += '<h5>Notable Files (' + d.notable_count + ')</h5><hr />';
                for(var f in d.notable)
                    output += d.notable[f] + '<br />';

                // affected files
                output += '<h5>Affected Files (' + d.affected_count + ')</h5><hr />';
                for(var f in d.affected)
                    output += d.affected[f] + '<br />';

                // all files
                output += '<h5>Scanned Files (' + d.count + ')</h5><hr />';
                for(var f in d.files)
                    output += d.files[f] + '<br />';

                $out.append(output);
                $load.hide();
            });
        return false;
    });

});