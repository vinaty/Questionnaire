<?php
$file = './réponses/'. $_POST["nom"]. '.' . $_POST["ville"]. '.txt';
$file = str_replace(' ', '-', $file); // Replaces all spaces with hyphens.
$file = str_replace('/[^A-Za-z0-9\-]/', '', $file); // Removes special chars.
$json_string = json_encode($_POST);
$file_handle = fopen("$file", 'a');
fwrite($file_handle, $json_string);
fclose($file_handle);
$img = $_POST["nom"]. '.' . $_POST["ville"];
$img = str_replace(' ', '-', $img);
$img = str_replace('/[^A-Za-z0-9\-]/', '', $img);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/main.css">
    <title>CTSA - Signature</title>
</head>
<body>
    <img src="./assets/logo_ctsa_res.png">
    <h1>Signature :</h1>
    <form id="form-submit" method="POST">
        <div class="wrapper">
            <canvas id="signature-pad" class="signature-pad"></canvas>
        </div>
        <button id="clear" class="btn btn-sm btn-secondary">Effacer</button>
        <button id="save" class="btn btn-success">Valider</button>
    </form>

    <br/>
    <hr>
    <h3>Une fois validé, vous pouvez enregistrer la signature en appuyant sur le bouton ci-dessous :</h3>
    <a href="" id="signature-img-result" download="<?php echo $img ?>.png" class="myButton">récupérer la signature</a>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
        $(function() {
            // init signaturepad
            var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'
            });

            // get image data and put to hidden input field
            function getSignaturePad() {
                var imageData = signaturePad.toDataURL('image/png');
                $('#signature-result').val(imageData)
                $('#signature-img-result').attr('href', "data:" + imageData);
            }

            // form action
            $('#form-submit').submit(function() {
                getSignaturePad();
                return false; // set true to submits the form.
            });

            // action on click button clear
            $('#clear').click(function(e) {
                e.preventDefault();
                signaturePad.clear();
            })
        });
    </script>
        <h2>Envoi de la signature</h2>
        <div class="spacer">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <fieldset>
        <p>Sélectionner la signature enregistré à l'étape précédente :</p>
        <input type="file" name="fileToUpload" id="fileToUpload" class="myButton">
        <input type="submit" value="Envoyer la signature" name="submit" class="myButton">
    </fieldset>
    </div>
    </form>
</body>
</html>