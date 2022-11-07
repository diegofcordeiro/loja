function modal( endereco ){

  $('#modal_conteudo').html("<div style='text-align:center;'><img src='"+dominio()+"views/img/loading.gif' style='width:25px;'></div>");
  $('#modal_janela').modal('show');
  
  $.post(endereco, { variaveis: '' },function(data){
    if(data){
      $('#modal_conteudo').html(data);
    }
  });

}

///////////////////////////////////////////////////////////////////

function numeroParaMoeda(n, c, d, t)
{
  c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

///////////////////////////////////////////////////////////////////
//Produtos

function ordena_lista(endereco){
  window.location=''+endereco;
}

//////////////////////////////////////////////////////////////////////////////////
/*Função  Pai de Mascaras*/
function Mascara(o,f){
  v_obj=o
  v_fun=f
  setTimeout("execmascara()",1)
}    
/*Função que Executa os objetos*/
function execmascara(){
  v_obj.value=v_fun(v_obj.value)
}    
/*Função que Determina as expressões regulares dos objetos*/
function leech(v){
  v=v.replace(/o/gi,"0")
  v=v.replace(/i/gi,"1")
  v=v.replace(/z/gi,"2")
  v=v.replace(/e/gi,"3")
  v=v.replace(/a/gi,"4")
  v=v.replace(/s/gi,"5")
  v=v.replace(/t/gi,"7")
  return v
}
/*Função que permite apenas numeros*/
function Integer(v){
  return v.replace(/\D/g,"")
}
function Data(v){
  v=v.replace(/\D/g,"") 
  v=v.replace(/(\d{2})(\d)/,"$1/$2") 
  v=v.replace(/(\d{2})(\d)/,"$1/$2") 
  return v
}

function telefone(v){
  var numeros = v.length;
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(0+)(\d)/g,"$2"); 
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    
    if(numeros == 15){
        v=v.replace(/(\d{5})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
      } else {
        v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos      
      }

      return v
    }
    function ceppp(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/(\d{5})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
  }
  function bloqueio(v){
    return ''
  }
  function moeda(v){ 
    v=v.replace(/\D/g,"") // permite digitar apenas numero 
    v=v.replace(/(\d{1})(\d{17})$/,"$1.$2") // coloca ponto antes dos ultimos digitos 
    v=v.replace(/(\d{1})(\d{13})$/,"$1.$2") // coloca ponto antes dos ultimos 13 digitos 
    v=v.replace(/(\d{1})(\d{10})$/,"$1.$2") // coloca ponto antes dos ultimos 10 digitos 
    v=v.replace(/(\d{1})(\d{7})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos 
    v=v.replace(/(\d{1})(\d{1,4})$/,"$1,$2") // coloca virgula antes dos ultimos 4 digitos 
    return v;
  }


 
/////////////////////////////////////////////////////////////////////////////////////////////////////
