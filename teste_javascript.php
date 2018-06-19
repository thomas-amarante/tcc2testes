<!DOCTYPE html>
<html>
<head>
    <title>teste</title>
    <meta charset="UTF-8" />
    <script type="text/javascript">
        function gravar(){
            var titulo = document.getElementById("txtTitulo").value;
            var subtitulo = document.getElementById("txtSubtitulo").value;
            const campo = document.getElementById("divResultado");

			campo.value = titulo;
        }
    </script>
</head>
<body>
    <div>s
        <label>Título:</label>
        <input type='text' id='txtTitulo'/>
        <label>Subtítulo:</label>
        <input type="text" id="txtSubtitulo"/>
        <button id="btnEnviar" onclick="gravar()" >Gravar</button>
    </div>
    <input id="divResultado" value="" />
    
</body>
</html>