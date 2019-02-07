<?php 
    //defindo idioma,local e horário para pt-br
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo'); 

    if(isset($_GET["btn"])){
        #resgatando valores...
        $autor = $_GET["txt_autor"];
        $artigo = $_GET["txt_artigo"];
        $site = $_GET["txt_site"];
        $url = $_GET["txt_url"];
        $date = $_GET["txt_date"];
        @$cb_autor = $_GET['cb_autor'];
        
        if(!$cb_autor){
            $autor = "<span class='upper'>$autor</span>";
        } else {
            //config nome do autor
            $format_autor = explode(" ", $autor);

            /**
             * caso o nome do autor for maior que 1, o programa retornará
             * o seu segundo nome primeiro em uppercase, de acordo com a norma
             * ABNT
             */
            if (sizeOf($format_autor) > 1)
                $autor = "<span class='upper'>". end($format_autor).",</span> ";
                
                /**
                 * o looping será util para trazer o restante do nome 
                 *completo do autor com excessão do último sobrenome.
                 */
                for($i = 0; $i < count($format_autor) - 1; $i++)
                    $autor = $autor. " ". $format_autor[$i];
        
        }
        //convertendo data padrão abnt
        $formatted_date = explode("-", $date);
        
        #o mktime() é necessário para que ele não 
        #traga um só mês por padrão
        $mon = mktime(0, 0, 0, $formatted_date[1], 10); 
        
        $date = $formatted_date[2]. " "
        ."<span class='lower'>". strftime('%b', $mon) .".</span>". 
        " " .$formatted_date[0];

        //config nome do site
        $format_site = explode(".", $site);
        $site = "<span class='cap'>".$format_site[0].
        "</span>";

        //restante do site virá com o looping
        for($i = 1; $i < count($format_site); $i++)
                    $site = $site. ".". $format_site[$i];

        //construindo referencia
        $ref_result = "$autor. <b>$artigo.</b> $site. 
        Disponível em: < $url /> Acesso em $date";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Language" content="pt-br">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Make your Reference!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
   
</head>
<body>
    <h1>Preencha o formulário abaixo para criar a referência</h1>
    <form method="GET" name="frmReference">
        <label for="txt_autor">Nome do Autor do Artigo:</label>
        <input type="text" name="txt_autor" class="input_format">
        Autoria Conhecida? <input type="checkbox" name="cb_autor">
        <br><br>

        <label for="txt_artigo">Nome do Artigo:</label>
        <input type="text" name="txt_artigo" class="input_format"><br><br>

        <label for="txt_site">Nome do Site:</label>
        <input type="text" name="txt_site" class="input_format"><br><br>

        <label for="txt_url">URL:</label>
        <input type="text" name="txt_url" class="input_format"><br><br>

        <label for="txt_date">Data de acesso:</label>
        <input type="date" name="txt_date" class="date"><br><br>
       
        <button type="submit" name="btn" class="btn">Submit</button>
        <button type="reset" class="btn">Limpar</button>
    </form>
    <label for="ta_ref">Resultado:</label><br>
    <div name="ta_ref" class="txtarea"><?php echo $ref_result?></div><br><br>
</body>
</html>