function mpModal ({
    title: title = "Title",
    size: size = "md",
    body: body = "mpModal Body",
    bg: bg = "dark",
    action: action = (() => null)
}){
    $(".mpModal").remove();
    var content = `
    <div class="mpModal" id="new" role="dialog">
        <div class="animated modal-${bg} fadeInUp custo-fadeInUp modal-dialog modal-${size} modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close close-button" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    <div class="compose-box">
                        <div class="compose-content">
                            <h5 class="modal-title px-3">${title}</h5>
                            <div class="modal-data">
                                ${body}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
    
    // zoomInUp animated custo-zoomInUp 
    document.body.insertAdjacentHTML('beforeend', content);
    const modal = document.querySelector(".mpModal");
    const closeButton = document.querySelector(".close-button");
    function toggleModal() {
        modal.classList.toggle("show-modal");
    }
    toggleModal();
    closeButton.addEventListener("click", toggleModal);
    return action();
}

function multiSelect(id,max = 3){
    return new Choices('#'+id, {
        removeItemButton: true,
        maxItemCount:max,
        searchResultLimit:10,
        placeHolder: "--Select-",
        // renderChoiceLimit:
    });
}
function tview(data){
    let content = `<table class=""><tbody>`;
    for(let key in data) {
        content += `<tr><th class="" style="width:170px;text-align:left;">${key.replaceAll("_"," ")} </th><th style="width:50px;"> : </th><td style="text-align:left">${data[key]}</td></tr>`
    }
    content +=`</tbody></table>`;
    return content;
}

function tdesc(data, title = "Description"){
    let content = `
        <div class="txt my-3">
        <h6 class="font-weight-bold tt">${title}</h6>
        <p class="modal-p">${data ?? "-"}</p>`;
    content +=`</div>`;
    return content;
}

const taction = (data) =>{
    return `<td class="text-center"><span class="d-none entry-row-info"></span>`+data+"</td>";
}

const TCHECK = (data) => {
    return `<label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
            <input type="checkbox" name="checkAll[]" class="new-control-input todochkbox chck"  value="${data}">
            <span class="new-control-indicator"></span>
    </label>`
};
                              
const tactionD = (data)=>{
    let content = `<td class="text-center"><div class="dropdown">
    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink2">`;
    return content + `${data}</div></div></td>`;
}

// change password
function cPassword() {
    return `<div class="di">
    <form id="fm">
        <input type="hidden" name="formaction" id="sendID" value="action">
        <div class="form-group">
            <input type="text" class="form-control" name="old-password" placeholder="Old Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="New Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="con-password" placeholder="Confirm New Password">
        </div>
        <input type="submit" class="btn btn-sm btn-block btn-primary modal-submit" value="Change Password">
        </form>
    </div>`;
}

/**
 * template for table body
 * @param data
 * @returns {string}
 */
const tbody = (data)=>{
    let content = "";
    data.forEach(val => {
        content += `<td class="checkbox-column text-wrap" >${val}</td>`;
    })
    return content;
}

/**
 * enum for status
 */
const stat = (data,id = "", cls = "")=>{
    let stat = $conf("gen").status[parseInt(data)];
    return `<a href="javascript:void(0);" class="badge ${cls} tstatus text-white font-weight-bold badge-${stat[1]}" data-view="statusView" data-title="Change Status" data-id="${id}" data-size="sm">${stat[0]}</a>`;
}

/**
 * enum for order type
 */
const orderType = (data)=>{
    return $conf("gen").orderType[parseInt(data)];
}

/**
 * file upload instruction
 * @param string type type of file
 * @param {string} size max size of file
 * @returns 
 */
const fileDirective = (type,size)=>{
    return `<small class="text-danger">File type must be ${type}, file size must not exceed ${size}</small>`
}


function bulkUpload(){
    return `<form id="fm" enctype="multipart/form-data">
        <input type="hidden" name="id">
        <div class="row">
            <div class="form-group col-md-12">
                <input type="file" class="form-control" name="file">
                ${fileDirective("CSV","2MB")}
            </div>
            
            <div class="col-md-12 d-flex justify-content-center">
                <input type="submit" class="btn btn-primary modal-submit" data-src="${$("#bulk").val()}" data-val="Upload Inventory" value="Upload Inventory">
            </div>
        </div>
    </form>`
}

/**
 * enum for user types
 */
const systemUser = (data)=>{
    return $conf("gen").user[parseInt(data)];
}

const tDate = (date) => {
    return (date == "" || date == null) ? "" :  $conf("gen").date(Number(date));
}

const tCurrency = (amt,currency = "") => {
    return $conf("gen").currency(Number(amt),currency);
}
const tTime = (date) => {
    return (date == "" || date == null) ? "" :  $conf("gen").time(Number(date));
}

/**
 * display select options
 * @array data
 * @param identity set identity to true if primary key is column value
 * @param val provide current value if you are updating
 * @returns {string}
 */
const getOptions = (data,loop = false,val="") =>{
    let content = "";
    data.forEach(element => {
        let id = element.entity_guid;
        let names = (element.code) ? element.name+" | "+element.code : element.name;
        if(loop){
            val.forEach(data => {
                if(id == data.category){
                    content += `<option value="${id}" selected>${names}</option>`;
                }else{
                    content += `<option value="${id}">${names}</option>`;
                }
            })
        }else{
            if(id == val){
                content += `<option value="${id}" selected>${names}</option>`;
            }else{
                content += `<option value="${id}">${names}</option>`;
            }
        }

    });
    return content;
}

function noRecord(colspan, text){
    return `
    <tr>
        <th colspan='${colspan}' class="text-center"><h6 class="text-primary">${text}</h6></th>
    </tr>
`
}

function tCategory(arr){
    if(arr !== 0 && arr.length !== 0) {
        var cati = [];
        arr.forEach(function(d2){
            cati.push(d2.name);
        })
        return cati.join(", ");
    }else{
        return "";
    }
}

let closeMp = () => $(".mpModal").remove();