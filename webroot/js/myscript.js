/*Navar Multiple DropDown Function*/
(function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').click(function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
                $('[data-toggle="popover"]').popover(); 
	});
})(jQuery);

function initilizeAddDocPage(){
        $('#fileinput').fileinput({
            'showUpload':false, 'previewFileType':'any'
        });
        $('#namedoc').change(function() {
            var e = document.getElementById("namedoc");  
            var idDoc = e.options[e.selectedIndex].value;
            //alert('ok');
            typeId = typesreq_array[idDoc];
            //alert(types_array[typeId]);
            $("#typedoc").val(typeId).change();
            //$("#typeSend").val(typeId).change();
            document.getElementById("typeSend").value = typeId;
            //typeId ====> 0 = obligatoire; 1 = en attente; 2 = copie; 3 = optionnel
            if(typeId == 0){
                $("#versiondoc").val('1').attr('disabled','disabled');
                document.getElementById("version_jq").value = 1;
            }else{
                $("#versiondoc").prop('disabled',false);
            }
            if(typeId == 1)
                $("#versiondoc").prop('required',true);
            else
                $("#versiondoc").prop('required',false);
            if((typeId == 2)||(typeId == 3))
                $("#versiondoc").val('');
        });
}

    
    
function initilizeAddFilePage() {
    var count = 0;
    $('.selectpicker').selectpicker({
      style: 'btn-info',
      size: 6
    });
    
    $('#select_clients').change(function() {
        var count = 0;
        var e = document.getElementById("select_clients");  
        var idClient = e.options[e.selectedIndex].value;
        for (var i in clients_array){
            if(idClient == clients_array[i]['id']){
                name = clients_array[i]['name'];
                code = clients_array[i]['code'];
                matriculeFiscale = clients_array[i]['matriculeFiscale'];
            }
        }
        if(count == 0){
            $("#tableinfoclient").removeClass("hidden");
        }
        document.getElementById("NomClient").innerHTML = name;
        document.getElementById("CodeClient").innerHTML = code;
        document.getElementById("MFClient").innerHTML = matriculeFiscale;
        document.getElementById("ClientIdSelect").value = idClient; 
        count++;
    });
    
    $('#select_providers').change(function() {
        //var count = 0;
        var e = document.getElementById("select_providers");  
        var idProvider = e.options[e.selectedIndex].value;
        /*for (var i in providers_array){
            if(idProvider == providers_array[i]['id']){
                name = providers_array[i]['name'];
            }
        }
        if(count == 0){
            $("#tableinfoclient").removeClass("hidden");
        }
        document.getElementById("NomProvider").innerHTML = name;*/
        document.getElementById("ProviderIdSelect").value = idProvider; 
        //count++;
    });
}

function initilizeAddLotPage(){
    //Disable Enter key for LotForm
    $(document).ready(function(){
        $(window).keydown(function(event){
          if(event.keyCode == 13) {
            event.preventDefault();
            return false;
          }
        });
        //Recuperer la valeur initiale de deadline pour l'itiliser à #datejours.change
        yearFile = document.getElementById("deadlineYear").value;
        monthFile = document.getElementById("deadlineMonth").value;
        dayFile = document.getElementById("deadlineDay").value;
    });
    
    // Add Lot & Edit Lot
   $('.selectpicker').selectpicker({
      style: 'btn-info',
      size: 6
    });
    
    $('#select_products').change(function(){
        var e = document.getElementById("select_products");  
        var idProduct = e.options[e.selectedIndex].value;
        //zone
        var zone = document.getElementById("input_zoneId");
        document.getElementById("ProductIdSelect").value = idProduct; 
        for (var i in products_array){
            if(idProduct == products_array[i]['id']){
                if (products_array[i]['unit'] != '')
                    unit = "(" +products_array[i]['unit'] + ")";
                else 
                    unit = "";
                if(products_array[i]['zone_id'] != null){
                    zone.value = products_array[i]['zone_id'];
                }else
                    zone.value = null;
                    //alert(products_array[i]['zone_id']);
            }
        }
        
        $('#expectedQteLabel').text("Quantité "+unit);
        infoAdd(idProduct, racine_ajax);
        afficherBtnSend();
    });
    $('#datejours').keyup(function(){
        var numberOfDaysToAdd = document.getElementById("datejours").value;
        //alert(numberOfDaysToAdd);
        
        var thisDate = new Date(yearFile + '-' + monthFile + '-' + dayFile);
        numberOfDaysToAdd = parseInt(numberOfDaysToAdd);
        
        //alert(thisDate + '///' +yearFile + '-' + monthFile + '-' + dayFile);
        
        thisDate.setDate(thisDate.getDate() + numberOfDaysToAdd); 
        thisYear = thisDate.getFullYear();
        thisMonth = thisDate.getMonth() + 1;
        thisDay = thisDate.getDate();
        
        if(thisMonth < 10) thisMonthString = '0' + thisMonth.toString();
        else thisMonthString = thisMonth.toString();
        if(thisDay < 10) thisDayString = '0' + thisDay.toString();
        else thisDayString = thisDay.toString();
        
        document.getElementById("deadlineYear").value = thisYear;
        document.getElementById("deadlineMonth").value = thisMonthString;
        document.getElementById("deadlineDay").value = thisDayString;
                //+ '-' + thisMonth + '-' + thisDay;
    });
    
    $('#datejours').blur(function(){
        $('#addjoursBtn').click();
        $("#addjoursBtn i").toggleClass("fa-plus-square fa-minus-square");
    });
    
    $('#addjoursBtn i').click(function(){
        $("#addjoursBtn i").toggleClass("fa-plus-square fa-minus-square");
    });
    //Quota
    //Affichage du boutton envoyer et modification sur Css d'alert
    $('#expectedQte').keyup(afficherBtnSend);
    //Test de verification avant le submit
    $('#lotForm').submit(function(event){
        //alert( "Handler for .submit() called." );
        //minquota = $("#minquota").text();
        mintolerance = $("#mintolerance").text();
        amountStock = $("#amountStock").text();
        thisQuota = document.getElementById("expectedQte").value;
        //minquota = parseInt(minquota);
        mintolerance = parseInt(mintolerance);
        amountStock = parseInt(amountStock);
        thisQuota = parseInt(thisQuota);
        //if((thisQuota) > (amountStock + mintolerance))
            //event.preventDefault();
      });
}

//Page Edit Lot 
function initilizeEditLotPage() {
    $('#expectedQte').keyup(function() {
        var e = document.getElementById("select_products");  
        var idProduct = e.options[e.selectedIndex].value;
        infoAdd(idProduct, racine_ajax);
        afficherBtnSend();
    });
    //$('#expectedQte').keyup(afficherBtnSend);
}
function afficherBtnSend(){
    //minquota = $("#minquota").text();
    mintolerance = $("#mintolerance").text();
    if(mintolerance != 'Null'){
       amountStock = $("#amountStock").text();
        //minquota = parseInt(minquota);
        mintolerance = parseInt(mintolerance);
        amountStock = parseInt(amountStock);
        thisQuota = document.getElementById("expectedQte").value;
        thisQuota = parseInt(thisQuota);
        if((amountStock > -1)&&(thisQuota > -1)&&(amountStock > (thisQuota))){
            //alert('1');
            $(".alert-quotaToleranceForm").removeClass("alert-danger");
            $(".alert-quotaToleranceForm").removeClass("alert-warning");
            $(".alert-quotaToleranceForm").addClass("alert-info");
            //$("#btnEnvoyer").removeClass("hidden");
        }else if((amountStock + mintolerance)  > (thisQuota)){
            //alert('2');
            $(".alert-quotaToleranceForm").removeClass("alert-info");
            $(".alert-quotaToleranceForm").removeClass("alert-danger");
            $(".alert-quotaToleranceForm").addClass("alert-warning");
            //$("#btnEnvoyer").removeClass("hidden");
        }else if((amountStock + mintolerance)  < (thisQuota)){
            //alert('3');
            $(".alert-quotaToleranceForm").removeClass("alert-info");
            $(".alert-quotaToleranceForm").removeClass("alert-warning");
            $(".alert-quotaToleranceForm").addClass("alert-danger");
            //$("#btnEnvoyer").addClass("hidden");
        }else{
            //alert('4');
            $(".alert-quotaToleranceForm").removeClass("alert-info");
            $(".alert-quotaToleranceForm").removeClass("alert-warning");
            $(".alert-quotaToleranceForm").addClass("alert-danger");
            //$("#btnEnvoyer").addClass("hidden");
        } 
    }
}

function infoAdd(idProduct, racine_ajax){
    $('div.alert-quotaToleranceForm').remove();
    $.ajax({
        type:"POST",
        //url:"/DSD/Lots/traitementAjaxQuota/"+idProduct+"/",
        url: racine_ajax + "Lots/traitementAjaxQuota/"+idProduct+"/",
        dataType: 'html',
        async:false,
        success: function(response){
            $("#responsecontainer").html(response); 
        },
        error: function () {
            alert('error');
        }
    });
    //minquota = $("#minquota").text();
    mintolerance = $("#mintolerance").text();
    amountStock = $("#amountStock").text();
    //if((amountStock != 'Null')&&(amountStock != 'quotaNotConsidered'))
    if(amountStock != 'Null')
        if(amountStock > 0)
            divtoAdd = "<strong>Quantité Maximale : </strong> <span id='amountStock'>"+amountStock+"</span>.<br><strong>Tolerance : </strong> <span id='mintolerance'>"+mintolerance+"</span>.";
        else
            divtoAdd = "<strong>Quantité Maximale dépassé par : </strong> <span> "+amountStock*-1+"</span><span id='amountStock' class='hidden'> "+amountStock+"</span>.<br><strong>Tolerance : </strong> <span id='mintolerance'>"+mintolerance+"</span>.";
    //else if(amountStock == 'quotaNotConsidered')
    //    divtoAdd = "Quota non considéré";
    else
        divtoAdd = "<strong>Illimité</strong>.";
    
    var div = document.createElement('div');
    div.className = 'alert-quotaToleranceForm alert alert-info fade in';
    div.innerHTML = divtoAdd;

    document.getElementById('addAlertQuota').appendChild(div);
    
    return false; 
}

function initilizeViewFilePage(){
    $('#btn-verification').click(function() {
        $("#verifLots").toggle("slow");
        $("#verifDocs").toggle("slow");
        //$("a.btn-primary").removeAttr("disabled");
        //alert();
        /*if($("a.btn-primary").attr("disabled") == "disabled"){
            $("a.btn-primary").removeAttr("disabled");
        }else{
            $("a.btn-primary").attr("disabled", "disabled");
        }*/
        if($("#generateInputBtn").attr("disabled") == "disabled"){
            $("#generateInputBtn").removeAttr("disabled");
        }else{
            $("#generateInputBtn").attr("disabled", "disabled");
        }
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $('#cantAddOutput').click(function(e) {
        alert("Pas de lot disponible à ajouter");
        e.preventDefault(); 
    });
    
    $('#generateInputBtn').click(function(){
        if($('#generateInputBtn').attr("disabled") == "disabled"){
            return false;
        }else{
            return confirm('Êtes vous sûr de vouloir générer un bon d\'entrée et modifier les stocks de ce dossier.');
        }
    });
}

function initilizeViewInputPage(divName){
    $('#printBonEntree').click(function() {
        printDiv('bonEntree');
    });
}


function initilizeAddOutputPage(){
    $('#select_lots').change(function() {
        //Ajouter les quantités
        var e = document.getElementById("select_lots");  
        var idLot = e.options[e.selectedIndex].value;
        document.getElementById("LotIdSelect").value = idLot; 
        for (var i in lots_array){
            if(idLot == lots_array[i]['id']){
                expectedQte = lots_array[i]['expectedQte'];
                remainedQte = lots_array[i]['remainedQte'];
            }
        }
        divtoAdd = "<strong>Quantité Initiale : </strong> <span>"+expectedQte+"</span>.";
        divtoAdd = divtoAdd + " <br><strong>Quantité disponible : </strong> <span id='remainedQte'>"+remainedQte+"</span>.";
        var div = document.createElement('div');
        div.className = 'alert-qte alert alert-info fade in';
        div.innerHTML = divtoAdd;
        $(".alert-qte").remove();
        document.getElementById('addQuantite').appendChild(div);
        //changer le max de l'input qte à la valeur de remainedQte
        $('#qte').attr('max', remainedQte);
        $('#maxQte').val(remainedQte);
        changeColorAlerte(remainedQte);
    });
    $('#qte').keyup(function() {
        changeColorAlerte(remainedQte);
    });
}

function changeColorAlerte(remainedQte){
    var qte = document.getElementById("qte").value;
    
    if((remainedQte >= qte)&&(qte != '')){
        $(".alert-qte").removeClass("alert-danger");
        $(".alert-qte").addClass("alert-info");
    }else{
        $(".alert-qte").addClass("alert-danger");
        $(".alert-qte").removeClass("alert-info");
    }
}  

function initilizeViewOutputPage(){
    $("#cantAddOutput").click(function(e){
        alert("Pas de lot disponible");
        e.preventDefault(); 
    });
    $('#btn-verification').click(function() {
        $("#verifLots").toggle("slow");
        //$("#verifDocs").toggle("slow");
        //$("a.btn-primary").removeAttr("disabled");
    });
}
function initilizeprintInputPage(){
    $(document).ready(function() {
        printDiv('bonEntree');
    });
}
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
    //mywindow.document.write( "<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\" media=\"print\"/>" );

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function initilizeprintOutputsetPage(){
    $(document).ready(function() {
        printDiv('bonAlever');
    });
}
function initilizeAddUserPage(){
    $('#role_select').change(function(){
       role_select = $('#role_select').val();
       //alert(role_select);
       var array_select = ['products_select', 'categories_select', 'clients_select', 'lots_select', 'files_select', 'users_select'];
       if(role_select === 'admin'){
            $.each(array_select, function( index, value ) {
                if(value !== 'users_select') $('#'+value).val(4);
                else $('#'+value).val(4);
              });
       }else if(role_select === 'membre'){
           $.each(array_select, function( index, value ) {
                if(value !== 'users_select') $('#'+value).val(2);
                else $('#'+value).val(0);
              });
       }else if(role_select === 'douanier'){
           $.each(array_select, function( index, value ) {
                if((value === 'products_select')||(value === 'lots_select')) $('#'+value).val(1);
                else $('#'+value).val(0);
              });
       }
       
    });
    $('#password2, #password1').keyup(function(){
        confirm_pw();
    });
}
function initilizeEditMyProfileUserPage(){
    $('#password2, #password1').keyup(function(){
        confirm_pw();
    });
}
function initilizeAddClientPage(){
    toggleMinusPlusBtn('#autreInfo');
}
function initializeEditClientPage(){
    toggleMinusPlusBtn('#autreInfo');
}
function toggleMinusPlusBtn(idDiv){
    $(idDiv).click(function(){
        $("#autreInfo i").toggleClass("fa-plus-square fa-minus-square");
    });
}

function confirm_pw(){
        password1 = $('#password1').val();
        password2 = $('#password2').val();
        success = '<i id="font-awesome" class="inline-block fa fa-check color-green" aria-hidden="true"></i>';
        wrong = '<i id="font-awesome" class="inline-block fa fa-times color-red" aria-hidden="true"></i>';
        
        if(!$("#font-awesome").length){
            if(password1 === password2){
                $(success).appendTo('#add-mark-pw');
            }else{
                $(wrong).appendTo('#add-mark-pw');
            }
        }else{
            if(password1 !== password2){
                if($('#font-awesome').hasClass('fa-check')){
                    $('#font-awesome').removeClass('fa-check');
                    $('#font-awesome').addClass('fa-times');
                    $('#font-awesome').removeClass('color-green');
                    $('#font-awesome').addClass('color-red');
                }
            }else{
                if($('#font-awesome').hasClass('fa-times')){
                    $('#font-awesome').removeClass('fa-times');
                    $('#font-awesome').addClass('fa-check');
                    $('#font-awesome').removeClass('color-red');
                    $('#font-awesome').addClass('color-green');
                }
            }
        }
}
function initilizeChooseClientPage(){
    if(id_client != -1){
        $('#select_client').ready(function(){idClient = getselect_client();});
    }
    $('#select_client').change(function(){
        idClient = getselect_client();
        $('#idClient').val(idClient);
    });
    $(document).ready(function(){//on cas de ne pas cocher les outputSets ou le client ce script conserve les info initialiser
        //var e = document.getElementById("select_client2"); 
        if (typeof idClient != 'undefined')
            $('#idClient').val(idClient);
        if (typeof idClient2 != 'undefined')
        $('#idClient2').val(idClient2);
    });
    $(document).on('click','#preview_btn', function(){
        //Get all checked ids
        var IDs = $("input:checkbox:checked").map(function(){
          return $(this).val();
        }).get(); 
        IDs_str = IDs.join(";");
        $("#modal-body").text(IDs_str);
        printOutputSets(IDs_str);
     });
}

function change_idclient_beforeSend(){
    //change idClient before send
    var e = document.getElementById("select_client2");  
    var idClient2 = e.options[e.selectedIndex].value;
    $('#idClient2').val(idClient2);
    //Change date before send
    date_year = document.getElementById("yearid").value;
    date_month = document.getElementById("monthid").value;
    date_day = document.getElementById("dayid").value;
    $('#date_year').val(date_year);
    $('#date_month').val(date_month);
    $('#date_day').val(date_day);
    //alert(carriers);
    //e.preventDefault();
}
function getselect_client() {
        var e = document.getElementById("select_client");  
        var idClient = e.options[e.selectedIndex].value;
        
        chooseClient(idClient);
        
        return idClient;
    }
function chooseClient(idClient){
    //alert()
    $.ajax({
        type:"POST",
        //url:"/DSD/Lots/traitementAjaxQuota/"+idProduct+"/",
        url: racine_ajax + "outputSets/traitementAjax/"+idClient+"/",
        dataType: 'html',
        async:false,
        success: function(response){
            $("#responsecontainer").html(response); 
        },
        error: function(){
            alert('Error');
        },
        complete: function(){
            //after choose entrepositaire and after this ajax function we will send carriers array to the form of ajax ctp.
            $('#carriers').val(carriers);
       }
    });
}
function printOutputSets(array_outputSets){
    $.ajax({
        type:"POST",
        //url:"/DSD/Lots/traitementAjaxQuota/"+idProduct+"/",
        url: racine_ajax + "outputSets/getOutputsByOutputsSets/"+array_outputSets+"/",
        dataType: 'html',
        async:false,
        success: function(response){
            $("#modal-body").html(response); 
        },
        error: function () {
            alert('error');
        }
    });
}

function initilizeprintRemovalVoucherPage(){
    $(document).ready(function() {
        printDiv('bonAlever');
    });
}

function updateActualQte(idLot){
    actualQte = $('#actualQte'+idLot).val();
    if(typeof actualQte == 'undefined'){
        alert('Error');
    }else{
        $.ajax({
            type:"POST",
            //url:"/DSD/Lots/traitementAjaxQuota/"+idProduct+"/",
            url: racine_ajax + "lots/updateActualQte/"+idLot+"/"+actualQte+"/",
            dataType: 'json',
            async:false,
            success: function(response){
                //$("#TDactualQte_"+idLot).html(response);
                //alert(response);
                data = JSON.parse(response.data);
                console.log(data.error);
                if(data.error == false)
                    $("#TDactualQte_"+idLot).html(data.html);
                else
                    $("#error").html(data.html);
            },
            error: function(){
                alert('error');
            }
        });
        
    }
}

function updateWarningMsg(idFile){
    
    $.ajax({
            type:"POST",
            //url:"/DSD/Lots/traitementAjaxQuota/"+idProduct+"/",
            url: racine_ajax + "files/updateWarningMsg/"+idFile+"/",
            dataType: 'html',
            async:false,
            success: function(response){
                $("#ajaxTrait").html(response); 
            },
            error: function () {
                alert('error');
            }
        });
    
}

function initializeAddCategPage(){
    addPicInputFile('#fileinput', false);
    addDocInputFile('#piece_jointe', false);
    addDocInputFile('#piece_jointe_2', false);
    addDocInputFile('#piece_jointe_3', false);
}
function addDocInputFile(id, enable){
    if(enable == false){
        $(id).fileinput({
            'showUpload':false, 
            'previewFileType':'any',
            'maxFileSize': 10240
        });
    }else{
        $(id).fileinput({
            'showUpload':false, 
            'previewFileType':'any',
            'maxFileSize': 10240
        }).fileinput('enable');
    }
}
function addPicInputFile(id, enable){
    if(enable == false){
        $(id).fileinput({
            'showUpload':false, 
            'previewFileType':['image'],
            'allowedFileTypes':['image'],
            'allowedFileExtensions':['jpg', 'gif', 'png'],
            'maxFileSize': 10240
        });
    }else{
        $(id).fileinput({
                'showUpload':false, 
                'previewFileType':['image'],
                'allowedFileTypes':['image'],
                'allowedFileExtensions':['jpg', 'gif', 'png'],
                'maxFileSize': 10240
            }).fileinput('enable');
    }
}
function initializeEditCategPage(){
    //initialisation Pictogramme
    addPicInputFile('#fileinput', false);
    //Si le button supp est checked le input file est disabled et vice versa
    $('#supp_pic').click(function(){
            if( $('#supp_pic').is(':checked') ){
                $('#fileinput').fileinput('disable');
            }else{
                addPicInputFile('#fileinput', true);
            }
    });
    
    $('#fileinput').on('fileselect', function(event) {
            $('#supp_pic').attr('disabled', 'disabled');
    });
    
    $('#fileinput').on('fileclear', function(event) {
        if(disable != 'true') // S'il y a pas de fichier à supp le bouton reste disabled
            $('#supp_pic').attr('disabled', false);
    });
    //initialisation Doc
    addDocInputFile('#doc_path', false);
    //Si le button supp est checked le input file est disabled et vice versa
    documentEditHandle('#supp_doc', '#doc_path', disableDoc);
    documentEditHandle('#supp_doc2', '#doc_path2', disableDoc2);
    documentEditHandle('#supp_doc3', '#doc_path3', disableDoc3);
}

function documentEditHandle(btnDeleteCheck, docPath, checkDisableDoc){
    $(btnDeleteCheck).click(function(){
        if( $(btnDeleteCheck).is(':checked') ){
            $(docPath).fileinput('disable');
        }else{
            addDocInputFile(docPath, true);
        }
    });
    $(docPath).on('fileselect', function(event) {
            $(btnDeleteCheck).attr('disabled', 'disabled');
    });
    
    $(docPath).on('fileclear', function(event){
        if(checkDisableDoc != 'true') // S'il y a pas de fichier à supp le bouton reste disabled
            $(btnDeleteCheck).attr('disabled', false);
    });
}

function initializeAddProductPage(){
    addPicInputFile('#fileinput', false);
    addDocInputFile('#piece_jointe', false);
    $('#subjectToQuota').click(function(){
        subjectToQuotaCheck();
    });
    subjectToQuotaCheck();
}

function subjectToQuotaCheck(){
    if( $('#subjectToQuota').is(':checked') ){
        $('#quotaId').val('').prop("disabled", "disabled");
        $('#toleranceId').val('').prop("disabled", "disabled");
    }else{
        $('#quotaId').prop("disabled", false);
        $('#toleranceId').prop("disabled", false);
    }
}

function initializeEditProductPage(){
    addPicInputFile('#fileinput', false);
    //Si le button supp est checked le input file est disabled et vice versa
    $('#supp_pic').click(function(){
            if( $('#supp_pic').is(':checked') ){
                $('#fileinput').fileinput('disable');
            }else{
                addPicInputFile('#fileinput', true);
            }
    });
    
    $('#fileinput').on('fileselect', function(event) {
            $('#supp_pic').attr('disabled', 'disabled');
    });
    $('#fileinput').on('fileclear', function(event) {
        if(disable != 'true') // S'il y a pas de fichier à supp le bouton reste disabled
            $('#supp_pic').attr('disabled', false);
    });
    
    //initialisation Doc
    addDocInputFile('#doc_path', false);
    //Si le button supp est checked le input file est disabled et vice versa
    $('#supp_doc').click(function(){
        if( $('#supp_doc').is(':checked') ){
            $('#doc_path').fileinput('disable');
        }else{
            addDocInputFile('#doc_path', true);
        }
    });
    
    $('#doc_path').on('fileselect', function(event) {
            $('#supp_doc').attr('disabled', 'disabled');
    });
    $('#doc_path').on('fileclear', function(event) {
        if(disableDoc != 'true') // S'il y a pas de fichier à supp le bouton reste disabled
            $('#supp_doc').attr('disabled', false);
    });
    
    $('#subjectToQuota').click(function(){
        subjectToQuotaCheck();
    });
    subjectToQuotaCheck();
}