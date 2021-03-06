<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 8 Barcode Generator Example - MyWebTuts.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">barcode "{{$kode}}"</h3>
                <!-- Get PNG Format Example -->
                <a href="data:image/png;base64,{{DNS1D::getBarcodePNG($kode, 'C128', 1 , 36 , array(0,0,0) , true)}}" download="{{$kode}}">Dowload</a>
            </div>
        </div>
    </div>
</body>
</html>