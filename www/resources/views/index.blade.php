
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Currency Converter</title>
    <script type="text/javascript" src="./bootstrap.min.js"></script>
    <script type="text/javascript" src="./bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="./jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./scripts.js"></script>

    <link rel="stylesheet" type="text/css" href="./bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap-grid.min.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap-reboot.min.css">
    <link rel="stylesheet" type="text/css" href="./style.css">

    <header class="mb-5">
        <div id='cssmenu'>
            <ul>
               <li><a href='#'><span>Home</span></a></li>
            </ul>
        </div>
    </header>
  </head>
  <body>
      <div class="container">
          <div class="row mb-5 justify-content-center">
              <input class="text-center" type="number" id="from" value="">&nbsp;USD
              <span class="mr-5 ml-5"> to </span>
              <input class="text-center mr-2" type="number" id="to">
              <select class="text-center" id="currency_select"></select>
          </div>
          <h3 class="text-center">Currency Rates as of <?php echo date('M d Y') ?></h3>
          <table class="table table-hover mt-3 text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" style="width:50%">Currency</th>
                  <th scope="col"style="width:50%">Rate</th>
                </tr>
              </thead>
              <tbody class="table-striped">
                  @foreach($currencies as $key => $currency)
                  <tr>
                      <td>{{ $currency["name"] }}</td>
                      <td>{{ number_format($currency["rate"], 2) }}</td>
                  </tr>
                  @endforeach
              </tbody>
        </table>
      </div>
 </body>

    <script type="text/javascript">
        $(document).ready(function(){
            var currencies = JSON.parse('<?php echo json_encode($currencies); ?>');
            console.log(currencies);

            $('#currency_select').ready(function(){
                $(currencies).each(function(){
                    $('#currency_select').append($("<option />").val(this.name).text(this.name));
                });
            });

            $('#currency_select').on('keyup',function(){
                var fromValue = parseInt($('#from').val());
                $('#to').val(convert_currency($('#currency_select').val(), fromValue, currencies));
            });

            $('#from').on('keyup', function(){
                var fromValue = parseInt($('#from').val());
                $('#to').val(convert_currency($('#currency_select').val(), fromValue, currencies));
            });

        });

        function convert_currency(name, fieldValue, currencyList){
            var currency_rate = currencyList.find(function(element){
                return element.name == name
            });
            return (fieldValue * currency_rate.rate).toFixed(2);

        }
    </script>
</html>
