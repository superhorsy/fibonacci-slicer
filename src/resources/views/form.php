<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fibonacci Slicer</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .error {
            display: none;
            color: red;
        }
    </style>
</head>
<body>

<form class="form-inline" id="myForm">
    <label class="sr-only" for="inlineFormInputFrom">From</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="From" name="from">

    <label class="sr-only" for="inlineFormInputName2">To</label>
    <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputTo" placeholder="To" name="to">

    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>
</form>
<div>
    <span class="error-from error"></span>
</div>

<div id="message"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>

<script>
    $(document).ready(function () {
        $('#myForm').submit(function (e) {
            // Remove the default function of form element
            e.preventDefault();

            // Hide the error if success
            $('.error').hide();

            // Serializing data
            var data = $(this).serialize();

            // Message after send
            $('#message').html('Sending...');
            console.log(data);
            $.ajax({
                type: 'POST',
                url: '/slice',
                data: data,
                dataType: 'json',
                success: function (d) {
                    console.log(d);

                    if (d.success) {
                        const unordered = d.payload;

                        function sortNumber(a, b) {
                            return a - b;
                        }

                        var content = `<table class="table table-striped"><thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Number</th>
    </tr>
  </thead>
<tbody>`;

                        Object.keys(unordered).sort(sortNumber)
                            .forEach(function (key) {
                                content += '<tr><th  scope="row">' + key + '</th><td>' + unordered[key] + '</td></tr>'
                            })

                        content += '</tbody></table>'

                        console.log(content);

                        $('#message').html('<div>' + content + '</div>')
                    } else if (d.message) {
                        $('span.error-from').show().text(d.message);
                        $('#message').html('');
                    };
                }
            })
        })
    })
</script>
