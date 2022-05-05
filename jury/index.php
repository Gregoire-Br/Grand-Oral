<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style/qr.css">

    <title>QR code</title>
</head>


<body>
    <div class="container-fluid">
        <h3 class="text-center text-white user-select-none">Scannez un QR Code</h3>
        <video width="100%" id="preview" autoplay></video>
        <p id="error" class="text-center text-white user-select-none"></p>
    </div>

    <script type="module">
        import QrScanner from './lib/QrScanner/qr-scanner.min.js';

        const video = document.getElementById("preview");
        const error = document.getElementById("error");

        const qrScanner = new QrScanner(video, result => alert(result.data), {
            highlightScanRegion: true,
            highlightCodeOutline: true,
        });

        if (QrScanner.hasCamera()) {
            qrScanner.start();
        } else {
            console.log("aaah");
        }
    </script>
</body>

</html>