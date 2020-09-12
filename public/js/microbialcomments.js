
$(document).ready(function(){
var tamc = $('input[id="rs_total0"]').attr("value");
var tymc = $('input[id="rs_total1"]').attr("value");

var tamc_specific = $('input[id="ac_total0"]').attr("value");
var tymc_specific = $('input[id="ac_total1"]').attr("value");
if ((tamc == 0) && (tymc == 0)) {
    $("#micro_product_comment").val ("No microbial contaminants were detected in the product");
    $('input[id="micro_product_conclution"]').val("Product passed the microbial load ananlysis");

}else if ((tamc <= tamc_specific) && (tymc <= tymc_specific)) {
    $("#micro_product_comment").val ("The level of total microbial count and that of the yeast and moulds in the product were within the acceptable specification");
    $('input[id="micro_product_conclution"]').val("Product passed the microbial load ananlysis");
    }
else if ((tamc == 0) && (tymc <= tymc_specific)) {
    $("#micro_product_comment").val ("No Microbial counts were detected in the product, whiles that of the yeast and moulds were within the acceptable specification");
    $('input[id="micro_product_conclution"]').val("Product passed the microbial load ananlysis");
    }
else if ((tamc == 0) && (tymc > tymc_specific)) {
    $("#micro_product_comment").val ("No Microbial counts were detected in the product, whiles that of the yeast and moulds were above the acceptable specification");
    $('input[id="micro_product_conclution"]').val("Product passed the microbial load ananlysis");
    } 
else if ((tymc == 0) && (tamc <= tamc_specific)) {
    $("#micro_product_comment").val ("The level of total microbial count in the product were within the acceptable specification whiles no yeast and moulds contaminants were detected in the product ");
    $('input[id="micro_product_conclution"]').val("Product passed the microbial load ananlysis");
    }
else if ((tymc == 0) && (tamc > tamc_specific)) {
    $("#micro_product_comment").val ("The level of total microbial count in the product were above the acceptable specification whiles no yeast and moulds contaminants were detected in the product ");
    $('input[id="micro_product_conclution"]').val("Product passed the microbial load ananlysis");
    } 

else{
    $("#micro_product_comment").val ("Comment not found");
    $('input[id="micro_product_conclution"]').val("Conclution not found"); 
}

console.log(tymc)
})