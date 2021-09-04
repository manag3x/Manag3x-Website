"use strict";
const FINANCE_CONFIG = new Map();
// FINANCE_CONFIG.set("page", {
//     "anchor_view" : "push-view",
//     "anchor_enable" : "anchor-tag",
//     "active" : $attr($id("website-page-url"),"content"),
//     "view" : $id("current-view").value,
//     "site_name" : $id("site-name").value,
// })
// FINANCE_CONFIG.set("res", {
//     "base" : $id("app-root-base").href,
//     "ctrl" : $id("ctrl").value ?? "",
//     "custom_img" : $id("custom-img").value,
//     "uploads" : $id("uploads-dir").value,
// })
FINANCE_CONFIG.set("gen",{
    permission : $sel(".permission") ? JSON.parse($html($sel(".permission"))) : "",
    status : $sel(".request-status") ? JSON.parse($html($sel(".request-status"))) : "",
    user : $sel(".s-user-type") ? JSON.parse($html($sel(".s-user-type"))) : "",
    orderType : $sel(".order-type") ? JSON.parse($html($sel(".order-type"))) : "",
    // date : (date) => moment(date,"YYYY-MM-DD").format("LLL"),
    date : (date) => moment.unix(date,"YYYY-MM-DD hh:mm:ss").format("LLL"),
    date2 : (date) => moment.unix(date,"YYYY-MM-DD").format("LLL"),
    time: (date) => moment.unix(date,"hh:mm A").format("hh:mm A"),
    table : (callback = () => null) => {
        $('table.dt-live-dom').each(function (i,_table) {

            // if($in($sela(".no-results-found")[i], _table)) return

            $(this).DataTable({
                retrieve: true,
                dom: "<'dt--top-section'<'row'<'col-6 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-6 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn btn-sm' },
                        { extend: 'csv', className: 'btn btn-sm' },
                        { extend: 'excel', className: 'btn btn-sm' },
                        { extend: 'print', className: 'btn btn-sm' }
                    ]
                },
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    sInfo: "Showing page _PAGE_ of _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Search...",
                    sLengthMenu: "Results :  _MENU_",
                },
                lengthMenu: [20, 50, 100],
                drawCallback: () => {
                    // $('.dataTables_wrapper table').removeClass('table-striped');
                    callback()
                }
            })

            let tableResponsive = $sela("table.dt-live-dom")[i]

            if($sel(".dropdown",tableResponsive)) {
                $style(tableResponsive, "min-height: 45vh")
            }
        })
    },
    maxLength : (inputType = "textarea") => $(inputType + '.max-textarea').maxlength({
        alwaysShow: true
    }),
    select : (parent = null) => $(".mano-auto-select").each( function() {
        let placeholder = $(this).data("placeholder")
        $(this).select2({
            placeholder: placeholder,
            dropdownParent: parent ?? $("." + CusWind.get.body.className.replaceAll(" ", ".")),
        })
    }),
    optionList: (selectList,value = "") => {
        let option = ""

        if(selectList.length === 0)
            option = `<option value="" disabled>No Result Found</option>`

        selectList.forEach(opt =>{
            option += `<option value="${opt.value}" ${opt.value === value ? "selected" : ""}>${opt.name}</option>`
        })

        return option
    },
    currency : (num,currency = "",locale = "en-US") => {
        return new Intl.NumberFormat(locale,{
            style: "currency",
            currency: currency,
        }).format(num)
    },
    /**
     * Activate the action buttons on a table automatically using the `table-actions` class
     * @param actionsObject
     * @example [...].tableAction({delete: ({id,name}) => [id,name,...]})
     */
    tableAction: (actionsObject = {}) =>{
        $sela(".table-actions").forEach((btn,i) =>{
            $on(btn, "click", e =>{
                e.preventDefault();
                $loop(actionsObject, (value, key) =>{
                    // the data-action value must be same with the key of the action being passed into the script
                    if($data(btn,"action") === key) {
                        let parentElement = btn.closest(".table-actions-parent")

                        value({
                            id: $data(btn, "id"),
                            name: decodeURIComponent($data(btn, "name")),
                            index: i, item: btn,
                            params: $data(btn, "params")?.split(","),
                            info: !$sel(".entry-row-info", parentElement) ? "" : JSON.parse($html($sel(".entry-row-info", parentElement)))
                        })
                    }
                })
            })
        })
    },
    /**
     * Form Generator
     * @param {string} className
     * @param {string} style
     * @param {boolean|string} submitBtn
     * @param {string} btnClass
     * @param {string} wrap the element to use in wrapping the elements [default = form]
     * @param {Array} fields takes multiple elements the form will need and displays in the order of inclusion; inputField below for format
     * @returns {string}
     **/
    form: ({
       className = "mano-auto-form-generator",
       style = "",
       submitBtn = true,
       btnClass = "mano-auto-form-generator-submit-button",
       wrap = "form",
       fields = []
   }) => {
        let notInputField = ['hr','heading','div','empty','hidden','fun'];
        let inputField = (index,{
            label = false,
            name= "",
            className = "",
            required= false,
            readOnly= false,
            disabled= false,
            checked= false,
            multiple= false,
            placeholder= "Enter text...",
            type= "text",
            color = "primary",
            rows= 4,
            col = 12,
            colMd = 12,
            colSm = 12,
            wrap = true,
            wrapStyle = "",
            wrapClass = "",
            value = "",
            style = "",
            group = null,
            accept = null,
            maxLength = false,
            fixType = "text",
            prefix = "",
            prefixClass = "",
            postfix = "",
            postfixClass = "",
            fun = () => null,
        }) => {
            let field,labelRaw,innerValue = "";

            required = required === true ? " required " : ""
            readOnly = readOnly === true ? " readonly " : ""
            disabled = disabled === true ? " disabled " : ""
            checked = checked === true ? " checked " : ""
            multiple = multiple === true ? " multiple " : ""
            maxLength = maxLength ? ` maxlength="${maxLength}" ` : ""
            accept = accept ? ` accept="${accept}" ` : ""
            name = name ? `name="${name}"` : ""

            if(value){
                innerValue = value
                value = `value="${value}"`
            }

            labelRaw = label;
            label = label ? `<label class="col-form-label text-left" for="mano-auto-form-generator-${index}">${label}</label>` : "";

            switch (type){
                case "textArea":
                    field = `<textarea style="${style}" id="mano-auto-form-generator-${index}" class="form-control max-textarea ${className}" rows="${rows}" placeholder="${placeholder}" 
                        ${name+maxLength+required+readOnly+disabled}>${innerValue}</textarea>`;
                    break;
                case "switch":
                    field = `<input type="checkbox" id="mano-auto-form-generator-${index}" value="${value}" class="js-switch ${className}" 
                        ${name+required+readOnly+disabled+checked} />`;
                    break;
                case "checkbox":
                    label = "";
                    field = `<div class="n-chk checkbox-fade fade-in-${color}">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-${color}">
                            <input type="checkbox" class="new-control-input" id="mano-auto-form-generator-${index}" value="${value}" 
                            ${name+required+readOnly+disabled+checked} />
                            <span class="cr new-control-indicator"></span>${labelRaw}
                        </label>
                    </div>`;
                    break;
                case "select":
                    field = `<select style="${style}" id="mano-auto-form-generator-${index}" class="form-control mano-auto-select ${className}" 
                        data-placeholder="${placeholder !== "Enter text..." ? placeholder : "Select an option..."}" 
                        ${name+required+readOnly+disabled+multiple}>${innerValue}</select>`;
                    break;
                case "hr": field = `<hr />`; break;
                case "heading": field = `<h4 class="sub-title ${className}" style="font-size: 1.2rem;${style}">${innerValue}</h4>`; break;
                case "div": field = `<div class="${className}" style="${style}">${innerValue}</div>`;break;
                case "fun": field = fun() ?? ""; break;
                case "empty": field = innerValue; break;
                case "hidden": field = `<input type="hidden" placeholder="${placeholder}" ${name+value+required} />`; break;
                case "input-fix":
                    let fix = (className, value) =>
                        `<div class="input-group-prepend"><span class="input-group-text ${className}">${value}</span></div>`

                    field = `<div class="input-group">${prefix ? fix(prefixClass,prefix) : ""}
                        <input type="${fixType}" id="mano-auto-form-generator-${index}" class="form-control ${className}" 
                            placeholder="${placeholder}" ${name+value+maxLength+required+readOnly+disabled}" />
                        ${postfix ? fix(postfixClass,postfix) : ""}
                    </div>`;break;
                default:
                    field = `<input style="${style}" type="${type}" id="mano-auto-form-generator-${index}" class="form-control ${className}" 
                        placeholder="${placeholder}" ${name+value+maxLength+required+readOnly+disabled+multiple+accept} />`;
                    break;
            }

            if(col > 12) col = 12;
            else if(col < 1) col = 1;

            return {
                field: notInputField.some((v) => v === type) ? field : (wrap === false ? `${label} ${field}` :
                    `<div class="form-group col-sm-${colSm} col-md-${colMd} col-xl-${col} m-b-30 ${wrapClass}" style="${wrapStyle}">${label} ${field}</div>`),
                group: group
            }
        };
        let form = wrap ? `<${wrap} class="${className}" style="${style}">` : "";
        let oldGroup = -2;
        let newGroup = -1;
        let totalElement = fields.length

        fields.forEach((ele,i) => {
            let group = ele.group ? "-" + ele.group : "";
            let rule = !notInputField.some(v => v === ele.type);
            oldGroup = fields[i - 1]?.group ?? -2;
            newGroup = fields[i + 1]?.group ?? -1;

            if((rule && i === 0) || (!notInputField.some(v => v === ele.type) && oldGroup !== ele.group))
                form += `<div class="row form-grouped${group}">`;

            form += inputField(ele.id ?? i,ele).field

            if((rule && newGroup !== ele.group) || (rule && i === (totalElement - 1)))
                form += "</div>"
        })

        // add submit button or custom button
        if(wrap === "form") {
            if (submitBtn === true)
                form += `<button class="btn btn-round btn-grd-success ${btnClass}">Submit <i class='icofont icofont-check-circled'></i></button>`;
            else if ($type(submitBtn) === "String")
                form += submitBtn;
        }

        return form + (wrap ? `</${wrap}>` : "");
    }
})

const $conf = key => FINANCE_CONFIG.get(key)

// configure the default layout of the Custom window boxes
CusWind.config({
    size: "md",
    closeOnBlur: false,
    wrapper: "background: #060818",
    head: "color: var(--fade); font-size: 1.12rem",
    body: "padding: 20px; text-align: center; color: var(--dark-text)",
    foot: "display: flex;",
});

const Preloader = (act = "show") =>{
    let loadScreen = $id("load_screen");

    if(act === "hide")
        return $style(loadScreen).display = "none"
    return $style(loadScreen).display = "block"
};