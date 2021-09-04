/**!
 * @fileOverview OsAi Minified JS Syntax (OMJ$)
 * @author Osahenrumwen Aigbogun
 * @version 2.0.0
 * @since 23/11/2019
 * @modified 06/05/2021
 * @license
 * Copyright (c) 2019 Osai LLC | loshq.net/about.
 *
 */
"use strict";

const $win = window;

const $doc = document;

const $obj = Object;

const $web = navigator;

const $loc = $win.location;

const $store = $win.localStorage;

const $isInt = str => /\d/.test(str) ? parseInt(str) : null;

const $lastValue = list => list[list.length - 1];

const $omjsError = (component, error, throwError = false, ...others) => {
    console.info("%cOMJ$ ERR :: `" + component + "` ERROR", "background: #e00; color: #fff; padding: 3px;");
    if (others) console.warn(...others);
    console.trace("%c" + error, "background: #fff3cd; color: #1d2124; padding: 2px;");
    if (throwError) throw Error("OMJ$ ERR Thrown");
};

const $id = (elementID, parent = $doc) => {
    try {
        return parent.getElementById(elementID);
    } catch (e) {
        $omjsError("$id", e, true);
    }
};

const $sel = (elementSelector, parent = $doc) => {
    try {
        return parent.querySelector(elementSelector);
    } catch (e) {
        $omjsError("$sel", e, true);
    }
};

const $sela = (elementSelector, parent = $doc) => {
    try {
        return parent.querySelectorAll(elementSelector);
    } catch (e) {
        $omjsError("$sela", e, true);
    }
};

const $tag = (elementTag, parent = $doc) => {
    try {
        return parent.getElementsByTagName(elementTag);
    } catch (e) {
        $omjsError("$tag", e, true);
    }
};

const $name = (elementName, parent = $doc) => {
    try {
        return parent.getElementsByName(elementName);
    } catch (e) {
        $omjsError("$name", e, true);
    }
};

const $cls = (elementClass, parent = $doc) => {
    try {
        return parent.getElementsByClassName(elementClass);
    } catch (e) {
        $omjsError("$cls", e, true);
    }
};

const $on = (element, event, listener, option = false) => {
    try {
        let addListener = (listenerElement,index) =>{
            let listenerFn = (e) => listener(e,element,index)
            if (option === "on" || option?.on) listenerElement["on" + event] = listenerFn;
            else if (option === "remove" || option === "del") listenerElement.removeEventListener(event, listenerFn, false);
            else {
                let eventList = event.split(",");
                if (eventList.length > 1)
                    eventList.forEach(listen => listenerElement.addEventListener(listen, listenerFn, option));
                else
                    listenerElement.addEventListener(event, listenerFn, option);
            }
        }

        if($type(element) === "Array")
            return element.forEach((ele, i) => addListener(ele, i))

        addListener(element)
    } catch (e) {
        $omjsError("$on", e, true);
    }
};

const $set = listener => $on($doc, "DOMContentLoaded", listener);

const $load = listener => $on($win, "load", listener);

const $attr = (element, attributeName, attributeValue = null) => {
    try {
        if (attributeValue !== null) {
            if (attributeValue === "remove" || attributeValue === "del")
                return element.removeAttribute(attributeName);
            else return element.setAttribute(attributeName, attributeValue);
        }
        return element.getAttribute(attributeName);
    } catch (e) {
        $omjsError("$attr", e, true);
    }
};

const $data = (element, dataName, value) => {
    if (value) return $attr(element, "data-" + dataName, value);
    return $attr(element, "data-" + dataName);
};

const $class = (element, action = null, ...className) => {
    if (!action) return element.classList; else if (action === "contains" || action === "contain" || action === "has") return element.classList.contains(className); else if (action === "index" || action === "key") {
        if (element) {
            let rtn = 0;
            $sela("." + element.classList.toString().replace(" ", ".")).forEach((v, i) => {
                if (v === element) return rtn = i;
            });
            return rtn;
        }
        return 0;
    }
    return className.forEach(classValue => {
        if (action === "add") {
            element.classList.add(classValue);
            return element;
        } else if (action === "remove" || action === "del") {
            element.classList.remove(classValue);
            return element;
        } else {
            element.classList.toggle(classValue);
            return element;
        }
    });
};

const $style = (element, cssProperties = null, pseudoElement = null) => {
    try{
        if (cssProperties === "css") return $win.getComputedStyle(element, pseudoElement);
        if (cssProperties !== null) return $attr(element, "style", cssProperties);
        return element.style;
    }catch (e) {
        $omjsError("$style", e, true, "%cThe selected element doesn't exist", "color:#e0a800");
    }
};

const $html = (element, where = null, code__moveTo = null) => {
    if (where === "inner" || where === "in") {
        try {
            return element.innerHTML = code__moveTo;
        } catch (e) {
            $omjsError("$html", e, true, "%cThe selected element doesn't exist", "color:#e0a800");
        }
    } else if (where === "del" || where === "remove") {
        try {
            return element.innerHTML = "";
        } catch (e) {
            $omjsError("$html", e, true, "%cThe selected element doesn't exist", "color:#e0a800");
        }
    } else if (where === "move") {
        try {
            return code__moveTo.appendChild(element);
        } catch (e) {
            $omjsError("$html", e, true, "%cEnsure `param 1` === Element being moved to `param 3`\nEnsure `param 3` === Parent Element receiving `param 1`", "color:#e0a800");
        }
    } else if (where === "wrap") {
        try {
            element.parentNode.insertBefore($doc.createElement(code__moveTo), element);
            return element.previousElementSibling.appendChild(element).parentElement;
        } catch (e) {
            $omjsError("$html", e, true, "%cEnsure the first parameter is a valid node\nEnsure a valid tag name was supplied to the third parameter` === Parent Element receiving `param 1`", "color: #e0a800");
        }
    } else if (!code__moveTo && !where) return element.innerHTML; else return element.insertAdjacentHTML(where, code__moveTo);
};

const $type = (element, silent = true) => {
    let result = $obj.prototype.toString.call(element).replace("[object ", "").replace("]", "");
    if (silent === false) {
        console.log("%cOMJ$ VIEW: $type", "background: #fff3cd; color: #1d2124; padding: 5px");
        console.info(element);
        console.log("%cObject Type: " + result, "background: #14242f; color: #fffffa; padding: 5px;");
    }
    return result;
};

const $loop = (obj, operation = (() => "nothing"), after_end = null) => {
    let prop = {
        length: 0,
        output: "",
        lastKey: "",
        lastValue: ""
    };
    for (let key in obj) {
        if (obj.hasOwnProperty(key)) {
            prop.length++;
            key = isNaN($isInt(key)) || $isInt(key) === null ? key : $isInt(key);
            prop.lastKey = key;
            prop.lastValue = obj[key];
            let x = operation(obj[key], key);
            if (x === "continue") continue;
            if (x === "break") break;
            prop.output += x !== "nothing" && x !== undefined ? x : "";
            if (x === "nothing") console.log("key:", key, "\nvalue:", obj[key]);
        }
    }
    if (after_end) prop.output = after_end(prop.output);
    return prop;
};

/**!
 * @fileOverview Helpful Plugins Developed With OMJ$
 * @author Osahenrumwen Aigbogun
 * @version 2.0.0
 * @since 23/11/2019
 * @modified 15/03/2021
 * @license Copyright (c) 2019 Osai LLC | loshq.net/about.
 */
const $in = (element, parent__selector = $doc, mode = "down") => {
    if (mode === "parent" || mode === "top") {
        if (parent === $doc) return false;
        try {
            if ($type(parent__selector) === "String") return element.closest(parent__selector);
            let x = element.parentNode;
            while (x) {
                if (x === $sel("body")) break; else if (x === parent__selector) return x;
                x = x.parentElement;
            }
        } catch (e) {
            $omjsError("$in", e, true);
        }
        return false;
    } else return parent__selector.contains(element);
};

const $get = (name, query = true) => {
    if (query) return new URLSearchParams($loc.search).get(name);
    let origin = $loc.origin, path = $loc.pathname, urlFileName = path.split("/")[path.split("/").length - 1], hash = $loc.hash ? $loc.hash.split("#")[1] : "", urlComplete = origin + path;
    switch (name) {
      case "origin":
        return origin;

      case "path":
      case "directory":
        return path;

      case "file":
      case "script":
        return urlFileName;

      case "hash":
        return hash;

      default:
        return urlComplete;
    }
};

const $ucFirst = string => {
    let fullString = "";
    string.split(" ").forEach(word => {
        let smallLetter = word.charAt(0);
        fullString += " " + word.replace(smallLetter, smallLetter.toUpperCase());
    });
    return fullString.trim();
};

const $mirror = (parentField, ...children) => {
    $on(parentField, "input", () => {
        children.forEach(kid => {
            if (parentField.value === undefined) kid.value = parentField.innerHTML; else kid.value = parentField.value;
        });
    });
};

const $mediaPreview = (elementToWatch, placeToPreview, other = {}) => {
    let placeholder = other.default ?? null;
    let type = other.type ?? 0;
    let event_wrap = other.event ?? true;
    let operation = other.operation ?? (() => "operation");
    let previewPlaceholder = placeholder ?? placeToPreview.src;
    let previewMedia = () => {
        let srcProcessed = [];
        if (type === 1) {
            let reader = new FileReader;
            $on(reader, "load", () => {
                if (elementToWatch.value !== "") {
                    placeToPreview.src = reader.result;
                    if (operation !== "operation") operation(reader.result);
                } else placeToPreview.src = previewPlaceholder;
            }, "on");
            reader.readAsDataURL(elementToWatch.files[0]);
        } else {
            if (placeToPreview !== "multiple") {
                if (elementToWatch.value !== "") {
                    srcProcessed = URL.createObjectURL(elementToWatch.files[0]);
                    placeToPreview.src = srcProcessed;
                } else placeToPreview.src = previewPlaceholder;
            } else {
                if (elementToWatch.value !== "") Array.from(elementToWatch.files).forEach(file => srcProcessed.push(URL.createObjectURL(file)));
            }
            if (operation !== "operation") operation(srcProcessed);
        }
    };
    if (event_wrap === true) $on(elementToWatch, "change", previewMedia, "on"); else if ($type(event_wrap) === "String") $on(elementToWatch, event_wrap, previewMedia, "on"); else previewMedia();
};

const $rand = (min, max, mode = 0, silent = true) => {
    min = Math.ceil(min), max = Math.floor(max);
    let x;
    if (mode === 1) {
        x = Math.floor(Math.random() * (max - min)) + min;
        if (silent === false) console.log("Rand (x => r < y):", x);
        return x;
    }
    x = Math.floor(Math.random() * (max - min + 1)) + min;
    if (silent === false) console.log("Rand (x => r <= y):", x);
    return x;
};

const $view = element => {
    let rect = element.getBoundingClientRect();
    let top = rect.top;
    let left = rect.left;
    let right = rect.right;
    let bottom = rect.bottom;
    let viewHeight = $win.innerHeight;
    let viewWidth = $win.innerWidth;
    let inView = true;
    if (top < 0 && bottom < 0 || top > viewHeight && bottom > viewHeight || (left < 0 && right < 0 || left > viewWidth && right > viewWidth)) inView = false;
    return {
        top: top,
        left: left,
        bottom: bottom,
        right: right,
        inView: inView
    };
};

const $hasFocus = element => {
    let active = $doc.activeElement;
    if ($in(active, element, "top")) return true;
    return active === element;
};

const $overflow = element => element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth;

const $check = (value, type) => {
    if ($type(value) !== "String") return false;
    switch (type) {
      case "name":
        return !!new RegExp("^[a-z ,.'-]+/i$", value);

      case "username":
        return !!new RegExp("^w+$", value);

      case "mail":
        return /^([a-zA-Z0-9_.\-+])+@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);

      default:
        return true;
    }
};

const $cookie = (name = "*", value = null, expire = null, path = "", domain = "") => {
    if (name === "*") return $doc.cookie.split(";");
    if (value === "del") return $doc.cookie = name + "=" + value + "; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    if (value) {
        const d = new Date, dn = new Date(d), days = (duration = 30) => dn.setDate(d.getDate() + duration);
        if ($type(expire) === "Number") expire = days(expire);
        expire = expire ?? new Date(days()).toUTCString();
        if (path) path = "path=" + path + ";";
        if (domain) domain = "domain=" + domain + ";";
        return $doc.cookie = `${name}=${value};expires=${expire};${path}${domain}"`;
    }
    let nameString = name + "=";
    value = $doc.cookie.split(";").filter(item => item.includes(nameString));
    if (value.length) {
        value[0] = value[0].trim();
        return value[0].substring(nameString.length, value[0].length);
    }
    return "";
};

/**!
 * This Function Depends on `OMJ$ Box Plugin`
 * @param element {HTMLElement|HTMLFormElement} Element to trigger form check or the form element itself
 * @param option {Object} Element to trigger form check or the form element itself
 * {string|function} option.errorDisplay manner in which the error message should be displayed [default=popUp]
 *      @value {errorDisplay} === "popUp"[default] || "create"[create error message after field] || function(){}
 * {string} option.errorMessage error text to return to user (not necessary if using function for {errorDisplay})
 * @return {boolean} [false] if field(s) is|are empty || [true] if field(s) is|are not empty
 */ const $form = (element, option = {}) => {
    let errorDisplay = option.display ?? "popUp";
    let errorMessage = option.message ?? "Please fill all required fields!";
    if (!(element.nodeName === "FORM")) element = element.closest("FORM");
    let elem = element.elements;
    let xErrMsg = () => {
        let e = $id("osai-err-msg");
        return $in(e) && e.remove();
    };
    let xTest = () => {
        $sela("input[data-osai-tested='true']").forEach(test => {
            $data(test, "osai-tested", "del");
        });
    };
    let aErrMsg = (formField, customMsg = errorMessage) => {
        if (errorDisplay === "popUp") {
            if ($data(formField, "osai-error") === null || $data(formField, "osai-error") === "") $data(formField, "osai-error", $style(formField, "css").background);
            osNote(customMsg, "danger");
            setTimeout(() => {
                formField.style.background = "#f40204 none padding-box";
                formField.focus();
            }, 100);
            $on(formField, "input,change", () => formField.style.background = $data(formField, "osai-error"));
        } else if (errorDisplay === "create") {
            let errBx = $id("osai-err-msg");
            $in(errBx) && errBx.remove();
            $html(formField, "afterend", `<div id="osai-err-msg">${customMsg}</div>`);
            setTimeout(() => {
                $style($id("osai-err-msg"), "font-size: 14px; background-color: #e25656; color: #fff; padding: 5px; margin: 5px auto; border-radius: 4px"), 
                formField.focus();
            }, 700);
            $on(formField, "input", xErrMsg);
        } else {
            try {
                errorDisplay();
            } catch (e) {
                $omjsError("$form", e, true, `%c "display" param can only take the following;\n"popup" for a popup notification\n"create" for a message directly under the required field\nOR a custom "function" from dev`, "background: #fff3cd; color: #1d2124");
            }
        }
        xTest();
        return false;
    };
    for (let i = 0; i < elem.length; i++) {
        let field = elem[i], test = field.name && field.required;
        if (test && (field.value.trim() === "" || field.value === undefined || field.value === null)) return aErrMsg(field); else if (test && field.type === "email" && !$check(field.value, "mail")) return aErrMsg(field, "Invalid email format, should be <div style='font-weight: bold; text-align: center'>\"[A-Za-Z_.-]@[A-Za-Z.-].[A-Za-Z_.-].[A-Za-Z]\"</div>"); else if (test && field.type === "checkbox" && field.checked === false) return aErrMsg(field, "Mark the required checkbox"); else if (test && field.type === "radio" && !$data(field, "osai-tested")) {
            let marked = 0;
            $name(field.name).forEach(radio => {
                $data(radio, "osai-tested", "true");
                if (marked === 1) return;
                if (radio.checked) marked = 1;
            });
            if (marked === 0) return aErrMsg(field, "Pick an option from the list of options");
        }
    }
    xTest();
    return true;
};

/**!
 * Acquire form data as string, object or FormData
 * @param {HTMLFormElement|HTMLElement}  form = Form to be fetched or an existing element within the form
 * @param {boolean} validate = if to validate form automatically [default = false]
 * @return {Object}
 * @example $getForm(formElement).string || $getForm(formElement).object || $getForm(formElement).file
 */ const $getForm = (form, validate = false) => {
    let formFieldsString = "";
    let formFieldsObject = {};
    let hasFile = false;
    let findForm = () => {
        if (form) {
            if (form.nodeName === "FORM") return form;
            return form.closest("FORM");
        }
    };
    let addField = (fieldName, value) => {
        formFieldsString += encodeURIComponent(fieldName) + "=" + encodeURIComponent(value) + "&";
        if ($lastValue(fieldName) === "]") {
            let name = fieldName.replace("[]", "");
            if (!formFieldsObject[name]) formFieldsObject[name] = [];
            formFieldsObject[name].push(value);
        } else formFieldsObject[fieldName] = value;
    };
    if (validate && !$form(findForm())) throw Error("Your form has not satisfied all required validation!");
    form = findForm();
    for (let i = 0; i < form.elements.length; i++) {
        let field = form.elements[i];
        if (field.name && field.type === "file") hasFile = true;
        if (!field.name || field.disabled || field.type === "file" || field.type === "reset" || field.type === "submit" || field.type === "button") continue;
        if (field.type === "select-multiple") $loop(field.options, v => {
            if (v.selected) addField(field.name, field.value);
        }); else if ((field.type === "checkbox" || field.type === "radio") && field.checked) addField(field.name, field.checked); else addField(field.name, field.value);
    }
    return {
        string: formFieldsString.slice(0, -1),
        object: formFieldsObject,
        file: new FormData(findForm()),
        hasFile: hasFile
    };
};

// const $preloader = (act = "show") => {
//     if (!$sel(".osai-preloader")) $html($sel("body"), "beforeend", `<div class="osai-preloader" style="display: none"><div class="style-2"></div></div>`);
//     if (!$sel(".osai-preloader-css")) $html($sel("head"), "beforeend", `<style type="text/css" class="osai-preloader-css">.osai-preloader{display: flex;position: fixed;width: 101vw;height: 101vh;justify-content: center;align-items: center;background: rgba(8,11,31,0.8);left: -5px;right: -5px;top: -5px;bottom: -5px;z-index: 16011}.style-2{display: flex;width: 50px;height: 50px;animation: styl2-0 1.5s infinite linear;}.style-2:before,.style-2:after {content: "";width: 50%;background-color: #31a6cc;background:linear-gradient(to right, rgba(117,88,165,1) 0%,rgba(37,184,213,1) 99%);clip-path: polygon(0 0, 100% 50%, 0% 100%);animation: inherit;animation-name: styl2-1;transform-origin: bottom left;}.style-2:before {clip-path: polygon(0 50%, 100% 0, 100% 100%);transform-origin: bottom right;--s: -1;}@keyframes styl2-0{0%,34.99%{transform: scaley(1)}35%,70%{transform: scaley(-1)}90%,100%{transform: scaley(-1) rotate(180deg)}}@keyframes styl2-1{0%,10%,70%,100%{transform: translateY(-100%) rotate(calc(var(--s, 1)*135deg))}35%{transform: translateY(0%) rotate(0deg)}}</style>`);
//     if (act === "show") return $style($sel(".osai-preloader"), "del");
//     return $style($sel(".osai-preloader"), "display:none");
// };

const $preloader = (act = "show") => {
    if (!$sel(".osai-preloader")) $html($sel("body"), "beforeend", `<div class="osai-preloader" style="display: none"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>`);
    if (!$sel(".osai-preloader-css")) $html($sel("head"), "beforeend", `<style type="text/css" class="osai-preloader-css">.osai-preloader{display: flex;position: fixed;width: 101vw;height: 101vh;justify-content: center;align-items: center;background: rgba(8,11,31,0.8);left: -5px;right: -5px;top: -5px;bottom: -5px;z-index: 16011}.lds-ellipsis { display: inline-block; position: relative; width: 80px; height: 80px; } .lds-ellipsis div { position: absolute; top: 33px; width: 13px; height: 13px; border-radius: 50%; background: #fff; animation-timing-function: cubic-bezier(0, 1, 1, 0); } .lds-ellipsis div:nth-child(1) { left: 8px; animation: lds-ellipsis1 0.6s infinite; } .lds-ellipsis div:nth-child(2) { left: 8px; animation: lds-ellipsis2 0.6s infinite; } .lds-ellipsis div:nth-child(3) { left: 32px; animation: lds-ellipsis2 0.6s infinite; } .lds-ellipsis div:nth-child(4) { left: 56px; animation: lds-ellipsis3 0.6s infinite; } @keyframes lds-ellipsis1 { 0% { transform: scale(0); } 100% { transform: scale(1); } } @keyframes lds-ellipsis3 { 0% { transform: scale(1); } 100% { transform: scale(0); } } @keyframes lds-ellipsis2 { 0% { transform: translate(0, 0); } 100% { transform: translate(24px, 0); }}</style>`);
    if (act === "show") return $style($sel(".osai-preloader"), "del");
    return $style($sel(".osai-preloader"), "display:none");
};

"use strict";

/**!
 * CURL (AJAX) built with OMJ$
 * @author Osahenrumwen Aigbogun
 * @version 2.0.1
 * @copyright (c) 2019 Osai LLC | loshq.net/about.
 * @since 05/01/2021
 * @modified 20/04/2021
 * @param url {string|Object} = url of request being sent or an object containing the url and options of the request
 * url should be passed using "action" as the key
 * @param option {Object}
 *  option.credential {boolean} = send request with credentials when working with CORS
 *  option.content {string} = XMLHTTPRequest [default = text/plain] only necessary when user wants to set custom dataType aside json,xml and native formData
 *  option.method {string} = method of request [default = GET]
 *  option.data {any} [use data or form] = data sending [only necessary for post method]
 *  option.form {HTMLFormElement} [use data or form]; this takes precedence over data. 
 *  The form that contains the data to be sent over a POST method; it automatically serializes the form appropriately for form or text; 
 *  specify type="json" for it to serialize to JSON when the fields contain no file input element; 
 *  ###NOTE### This prop is useless in strict mode
 *  option.return {string} = the type of data to be returned
 *  option.type {string} = type of data to be sent/returned [default = text]
 *  option.alert {bool} = to use js default alert or OMJ$ default alert notifier [default=false]
 *  option.strict {bool} = [default=false] when true, automatic actions like; JSON.parse for resolve that comes as JSON text will be stopped
 *  option.preload {function} = function to carryout before response is received
 *  option.progress {function} = function to execute, while upload is in progress [one arg (response)]
 *  option.error {function} = it executes for all kinds of error, it's like the finally of errors
 *  option.loaded {function} = optional callback function that should be executed when the request is successful, 
 *  either this or a promise
 *  option.abort {function} = function to execute on upload abort
 * @return {Promise}
 */ const $curl = (url, option = {}) => new Promise((resolve, reject) => {
    if ($type(url) === "Object") {
        option = url;
        url = option.action;
    }
    let xhr = false, response, failure;
    let credential = option.credential ?? false;
    let content = option.content ?? "text/plain";
    let method = option.method ?? "get";
    let data = option.data ?? "";
    let form = option.form ?? "";
    let rtn = option.return ?? "text";
    let type = option.type ?? "text";
    let alert_error = option.alert ?? false;
    let strict = option.strict ?? false;
    let preload = option.preload ?? (() => "preload");
    let progress = option.progress ?? (() => "progress");
    let error = option.error ?? (() => "error");
    let timeout = option.timeout ?? (() => {
        failure = "Request timed out!";
        alert_error ? alert(failure) : osNote(failure, "warn");
    });
    let loaded = option.loaded ?? (() => "loaded");
    let abort = option.abort ?? (() => osNote("Request aborted!", "warn"));
    let errRoutine = (msg, xhr) => {
        if (error(status, xhr) === "error") {
            alert_error ? alert(msg) : osNote(msg, "fail");
            $omjsError("$curl", xhr.e ?? xhr.statusText);
            reject(Error(xhr.e ?? xhr.statusText), xhr);
        }
    };
    method = method.toUpperCase();
    type = type.toLowerCase();
    if (xhr = new XMLHttpRequest) {
        if (credential) xhr.withCredentials = true;
        if (form || data) method = "post";
        xhr.open(method, url, true);
        xhr.timeout = 6e4;
        $on(xhr.upload, "progress", event => progress(event));
        $on(xhr, "error", () => errRoutine("An error occurred" + xhr.statusText, xhr));
        $on(xhr, "abort", abort);
        $on(xhr, "timeout", timeout, "on");
        $on(xhr, "readystatechange", event => {
            let state = xhr.readyState;
            let status = xhr.status;
            if (state === 4) {
                switch (status) {
                  case 200:
                    if (method === "HEAD") response = xhr; else {
                        if ((xhr.responseText.substring(0, 1) === "{" || xhr.responseText.substring(0, 1) === "[") && type !== "json" && strict === false) type = "json";
                        if (type !== "json") type = rtn;
                        if (type === "xml") response = xhr.responseXML; else if (type === "json") {
                            try {
                                response = JSON.parse(xhr.response);
                            } catch (e) {
                                xhr["e"] = e;
                                errRoutine("Request error, refer to console log", xhr);
                            }
                        } else response = xhr.responseText;
                    }
                    if (loaded !== "loaded") loaded(response, xhr, event);
                    resolve(response, xhr, event);
                    break;

                  default:
                    errRoutine("Request Failed, internet connection might not be available", xhr);
                    break;
                }
            }
        });
        if (form && strict === false) {
            form = $getForm(form, true);
            if (form.hasFile) {
                data = form.file;
                type = "file";
            } else data = type === "json" ? form.object : form.string;
        }
        if (type !== "file") {
            let requestHeader = "application/x-www-form-urlencoded";
            if (type === "json") {
                if (method !== "GET") requestHeader = "application/json";
                data = JSON.stringify(data);
            } else if (type === "text" && $type(data) === "Object" && strict === false) {
                data = $loop(data, (value, name) => {
                    value = name + "=" + value + "&";
                    return value;
                }, value => value.replace(/&+$/, "")).output;
            } else if (type === "xml" && method !== "GET") requestHeader = "text/xml"; else if (type === "custom" && method !== "GET") requestHeader = content;
            xhr.setRequestHeader("Content-Type", requestHeader);
        }
        xhr.send(data);
        preload();
    }
});

const $freezeBtn = (btn, freeze = true) => {
    if (freeze === true) {
        $class(btn, "add", "disabled");
        $attr(btn, "disabled", "true");
    } else {
        $class(btn, "del", "disabled");
        $attr(btn, "disabled", "del");
    }
};

const $freeze = (element, operation) => {
    if (!$class(element, "has", "disabled")) {
        $freezeBtn(element);
        operation()?.finally(() => $freezeBtn(element, false));
    }
};

"use strict";

/**!
 * Osai Custom Box buils with OMJ$
 * @author Osahenrumwen Aigbogun
 * @version 1.0.0
 * @copyright (c) 2019 Osai LLC | loshq.net/about.
 * @modified 02/03/2021
 */ const $osaiBox = (boxToDraw = "all") => {
    const colorVariant = `\n\t\t/*normal variant*/\n\t\t--text: #fffffa;\n\t\t--bg: #1d2124;\n\t\t--link: #009edc;\n\t\t--info: #00658d;\n\t\t--warn: #e0a800;\n\t\t--fail: #f40204;\n\t\t--fade: #e2e2e2;\n\t\t--success: #0ead69;\n\t\t/*dark variant*/\n\t\t--dark-text: #f5f7fb;\n\t\t--dark-link: #00506e;\n\t\t--dark-info: #14242f;\n\t\t--dark-warn: #626200;\n\t\t--dark-fail: #620102;\n\t\t--dark-success: #104e00;\n\t`;
    const ggIcon = `.gg-bell,.gg-bell::before{border-top-left-radius:100px;border-top-right-radius:100px}.gg-bell{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));border:2px solid;border-bottom:0;width:14px;height:14px}.gg-bell::after,.gg-bell::before{content:"";display:block;box-sizing:border-box;position:absolute}.gg-bell::before{background:currentColor;width:4px;height:4px;top:-4px;left:3px}.gg-bell::after{border-radius:3px;width:16px;height:10px;border:6px solid transparent;border-top:1px solid transparent;box-shadow:inset 0 0 0 4px,0 -2px 0 0;top:14px;left:-3px;border-bottom-left-radius:100px;border-bottom-right-radius:100px}.gg-check{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));width:22px;height:22px;border:2px solid transparent;border-radius:100px}.gg-check::after{content:"";display:block;box-sizing:border-box;position:absolute;left:3px;top:-1px;width:6px;height:10px;border-width:0 2px 2px 0;border-style:solid;transform-origin:bottom left;transform:rotate(45deg)}.gg-check-o{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));width:22px;height:22px;border:2px solid;border-radius:100px}.gg-check-o::after{content:"";display:block;box-sizing:border-box;position:absolute;left:3px;top:-1px;width:6px;height:10px;border-color:currentColor;border-width:0 2px 2px 0;border-style:solid;transform-origin:bottom left;transform:rotate(45deg)}.gg-bulb{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));width:16px;height:16px;border:2px solid;border-bottom-color:transparent;border-radius:100px}.gg-bulb::after,.gg-bulb::before{content:"";display:block;box-sizing:border-box;position:absolute}.gg-bulb::before{border-top:0;border-bottom-left-radius:18px;border-bottom-right-radius:18px;top:10px;border-bottom:2px solid transparent;box-shadow:0 5px 0 -2px,inset 2px 0 0 0,inset -2px 0 0 0,inset 0 -4px 0 -2px;width:8px;height:8px;left:2px}.gg-bulb::after{width:12px;height:2px;border-left:3px solid;border-right:3px solid;border-radius:2px;bottom:0;left:0}.gg-danger{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));width:20px;height:20px;border:2px solid;border-radius:40px}.gg-danger::after,.gg-danger::before{content:"";display:block;box-sizing:border-box;position:absolute;border-radius:3px;width:2px;background:currentColor;left:7px}.gg-danger::after{top:2px;height:8px}.gg-danger::before{height:2px;bottom:2px}.gg-dark-mode{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));border:2px solid;border-radius:100px;width:20px;height:20px}\n\t.gg-close-o{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));width:22px;height:22px;border:2px solid;border-radius:40px}.gg-close-o::after,.gg-close-o::before{content:"";display:block;box-sizing:border-box;position:absolute;width:12px;height:2px;background:currentColor;transform:rotate(45deg);border-radius:5px;top:8px;left:3px}.gg-close-o::after{transform:rotate(-45deg)}\n\t.gg-close{box-sizing:border-box;position:relative;display:block;transform:scale(var(--ggs,1));width:22px;height:22px;border:2px solid transparent;border-radius:40px}.gg-close::after,.gg-close::before{content:"";display:block;box-sizing:border-box;position:absolute;width:16px;height:2px;background:currentColor;transform:rotate(45deg);border-radius:5px;top:8px;left:1px}.gg-close::after{transform:rotate(-45deg)}.gg-add-r{box-sizing:border-box;position:relative;display:block;width:22px;height:22px;border:2px solid;transform:scale(var(--ggs,1));border-radius:4px}.gg-add-r::after,.gg-add-r::before{content:"";display:block;box-sizing:border-box;position:absolute;width:10px;height:2px;background:currentColor;border-radius:5px;top:8px;left:4px}.gg-add-r::after{width:2px;height:10px;top:4px;left:8px}.gg-add{box-sizing:border-box;position:relative;display:block;width:22px;height:22px;border:2px solid;transform:scale(var(--ggs,1));border-radius:22px}.gg-add::after,.gg-add::before{content:"";display:block;box-sizing:border-box;position:absolute;width:10px;height:2px;background:currentColor;border-radius:5px;top:8px;left:4px}.gg-add::after{width:2px;height:10px;top:4px;left:8px}.gg-adidas{position:relative;box-sizing:border-box;display:block;width:23px;height:15px;transform:scale(var(--ggs,1));overflow:hidden}\n\t`;
    if (!$in($sel(".osai-gg-icon-abstract"))) $html($sel("head"), "beforeend", `<style class="osai-gg-icon-abstract">.osai-dialogbox ,.osai-notifier {${colorVariant}font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; box-sizing: border-box; scroll-behavior: smooth;} ${ggIcon}</style>`);
    let dialog = {}, notifier = {};
    if (boxToDraw === "all" || boxToDraw === "dialog" || boxToDraw === "modal") {
        if (!$in($sel(".osai-dialogbox__present"))) $html($sel("body"), "beforeend", `\n\t\t\t\t<div class="osai-dialogbox">\n\t\t\t\t\t<div class="osai-dialogbox__overlay"></div>\n\t\t\t\t\t<div class="osai-dialogbox__wrapper">\n\t\t\t\t\t\t<button class="osai-dialogbox__close-btn gg-close"></button>\n\t\t\t\t\t\t<div class="osai-dialogbox__head"></div>\n\t\t\t\t\t\t<div class="osai-dialogbox__inner-wrapper">\n\t\t\t\t\t\t\t<div class="osai-dialogbox__body"></div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class="osai-dialogbox__foot"></div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<span style="display: none" class="osai-dialogbox__present"></span>\n\t\t\t\t</div>`);
        if (!$in($sel(".osai-dialogbox__stylesheet"))) $html($sel("head"), "beforeend", `<style class="osai-dialogbox__stylesheet" type="text/css" rel="stylesheet" media="all">\n\t\t\t.osai-dialogbox__overlay{\n\t\t\t\tdisplay: none;\n\t\t\t\topacity: .5;\n\t\t\t\tposition: fixed;\n\t\t\t\ttop: 0;\n\t\t\t\tbottom: 0;\n\t\t\t\tleft: 0;\n\t\t\t\tright: 0;\n\t\t\t\tbackground: var(--bg);\n\t\t\t\tz-index: 16000;\n\t\t\t}\n\t\t\t.osai-dialogbox__wrapper{\n\t\t\t\tdisplay: none;\n\t\t\t\topacity: 0;\n\t\t\t\tjustify-content: center;\n\t\t\t\talign-items: center;\n\t\t\t\tmax-width: 97vw;\n\t\t\t\tmax-height: 97vh;\n\t\t\t\tposition: fixed;\n\t\t\t\tz-index: 16010;\n\t\t\t\ttransform: translate(-50%,0);\n\t\t\t\ttop: 50%; left: 50%;\n\t\t\t\tmargin: auto;\n\t\t\t\tbackground: var(--dark-text);\n\t\t\t\tborder-radius: 8px;\n\t\t\t\tflex-flow: column;\n                transition: ease-in-out .8s all;\n\t\t\t}\n\t\t\t.osai-dialogbox__close-btn{\n\t\t\t\tposition: absolute;\n\t\t\t\ttop: -4px;\n\t\t\t\tleft: -4px;\n\t\t\t\tbackground: var(--dark-text);\n\t\t\t\tcolor: var(--dark-fail);\n\t\t\t\tdisplay: flex;\n\t\t\t\tjustify-content: center;\n\t\t\t\talign-items: center;\n\t\t\t\tborder: solid 1px transparent;\n\t\t\t\tfont-size: 1rem;\n\t\t\t\tfont-weight: 500;\n\t\t\t\tcursor: pointer;\n\t\t\t\toutline: none;\n\t\t\t\tz-index: 2;\n\t\t\t}\n\t\t\t.osai-dialogbox__close-btn:hover{\n\t\t\t\tcolor: var(--fail);\n\t\t\t}\n\t\t\t.osai-dialogbox__head{\n\t\t\t\tfont-size: 1.5rem;\n\t\t\t\tpadding: 15px 5px 0;\n\t\t\t\tcolor: var(--bg);\n\t\t\t\tmargin: 5px auto;\n\t\t\t\tborder-bottom: dotted 1px var(--fade);\n\t\t\t\tfont-weight: 600;\n\t\t\t\twidth: 100%;\n\t\t\t\ttext-align: center;\n\t\t\t}\n\t\t\t.osai-dialogbox__inner-wrapper{\n                position: relative;\n                z-index: 1;\n                overflow: auto;max-width:100vw;}\n\t\t\t.osai-dialogbox__body{\n\t\t\t\tfont-size: 1rem;\n\t\t\t\tpadding: 10px;\n\t\t\t\tcolor: var(--bg);\n\t\t\t}\n\t\t\t.osai-dialogbox__foot{\n\t\t\t\tpadding: 5px;\n\t\t\t\tdisplay: flex;\n\t\t\t\tjustify-content: center;\n\t\t\t\talign-items: center;\n\t\t\t\tborder-top: dotted 1px var(--fade);\n\t\t\t\twidth: 100%;\n\t\t\t}\n\t\t\t.osai-dialogbox__foot button.success{\n\t\t\t\tbackground: var(--success);\n\t\t\t\tcolor: var(--bg);\n\t\t\t} .osai-dialogbox__foot button.success:hover{\n\t\t\t\tbackground: var(--dark-success);\n\t\t\t\tcolor: var(--dark-text);}\n\t\t\t.osai-dialogbox__foot button.fail{\n\t\t\t\tbackground: var(--fail);\n\t\t\t\tcolor: var(--text);\n\t\t\t}.osai-dialogbox__foot button.fail:hover{\n\t\t\t\tbackground: var(--dark-fail);\n\t\t\t\tcolor: var(--text);}\n\t\t\t.osai-dialogbox__foot button.warn{\n\t\t\t\tbackground: var(--warn);\n\t\t\t\tcolor: var(--text);\n\t\t\t} .osai-dialogbox__foot button.warn:hover{\n\t\t\t\tbackground: var(--dark-warn);\n\t\t\t\tcolor: var(--text);}\n\t\t\t.osai-dialogbox__foot button.info{\n\t\t\t\tbackground: var(--info);\n\t\t\t\tcolor: var(--dark-text);\n\t\t\t} .osai-dialogbox__foot button.info:hover{\n\t\t\t\tbackground: var(--dark-info);\n\t\t\t\tcolor: var(--text);}\n\t\t\t.osai-dialogbox__foot button:hover{\n\t\t\t\topacity: .8;\n\t\t\t}\n\t\t\t.osai-dialogbox__foot button.link{\n\t\t\t\tbackground: var(--link);\n\t\t\t\tcolor: var(--dark-text);\n\t\t\t} .osai-dialogbox__foot button.link:hover{\n\t\t\t\tbackground: var(--dark-link);\n\t\t\t\tcolor: var(--text);}\n\t\t\t.osai-dialogbox__foot button:hover{\n\t\t\t\topacity: .8;\n\t\t\t}\n\t\t\t/* disable scrolling when modal is opened */\n\t\t\t.osai-modal__open{\n\t\t\t\toverflow-y: hidden;\n\t\t\t\tscroll-behavior: smooth;\n\t\t\t}\n\t\t\t.osai-modal__appear{\n\t\t\t\topacity: 1;\n\t\t\t\ttransform: translate(-50%,-50%);\n\t\t\t}\n\t\t\t.osai-modal__btn{\n                border-radius: 20px;\n                border: solid 1px transparent;\n                padding: 10px;\n                cursor: pointer;\n                outline: none;\n                transition: all .5s ease-in-out;\n                background-color: var(--bg);\n                color: var(--text);\n                font-weight: 500;\n                margin: 0 5px;\n            }\n\t\t\t@media screen and (max-width: 600px){\n\t\t\t  .osai-dialogbox__wrapper{\n\t\t\t\tmin-width: 90vw;\n\t\t\t\tmax-width: 95vw;\n\t\t\t\tmax-height: 90vh;\n\t\t\t  }\n\t\t\t}\n\t\t</style>`);
        const BOX_OVERLAY = $sel(".osai-dialogbox__overlay");
        const BOX_WRAPPER = $sel(".osai-dialogbox__wrapper");
        const BOX_CLOSE_BTN = $sel(".osai-dialogbox__close-btn");
        const BOX_INNER_WRAPPER = $sel(".osai-dialogbox__inner-wrapper");
        const BOX_HEAD = $sel(".osai-dialogbox__head");
        const BOX_BODY = $sel(".osai-dialogbox__body");
        const BOX_FOOT = $sel(".osai-dialogbox__foot");
        const BOX_PRESENCE = $sel(".osai-dialogbox__present");
        $on($sel(".osai-dialogbox__close-btn"), "click", () => BOX_CLOSE());
        const BOX_VIEW = (act = "close") => {
            $class($sel("html"), "del", "osai-modal__open");
            if (act === "open") $class($sel("html"), "add", "osai-modal__open");
        };
        const BOX_SIZE = size => {
            switch (size) {
              case "sm":
                BOX_INNER_WRAPPER.style.minWidth = "25vw";
                break;

              case "md":
                BOX_INNER_WRAPPER.style.minWidth = "50vw";
                break;

              case "lg":
                BOX_INNER_WRAPPER.style.minWidth = "75vw";
                break;

              case "full":
                BOX_INNER_WRAPPER.style.minWidth = "99vw";
                break;

              default:
                let configSelector = config => $sel("input[data-config='" + config + "'].osai-dialogbox__config");
                if (configSelector("box-size") && $data(configSelector("box-size"), "value") !== "undefined") BOX_SIZE($data(configSelector("box-size"), "value")); else BOX_INNER_WRAPPER.style.minWidth = "50vw";
                break;
            }
        };
        const BOX_RENDER = (closeOnBlur, size, align, onClose) => {
            let configSelector = config => $sel("input[data-config='" + config + "'].osai-dialogbox__config");
            $class(BOX_WRAPPER, "del", "osai-modal__appear");
            BOX_VIEW("open");
            BOX_SIZE(size);
            $style(BOX_OVERLAY, "display:block;height: 100%;width:100%;");
            $style(BOX_WRAPPER, "display: flex;");
            if (configSelector("main-wrapper")) $style(BOX_WRAPPER, "display: flex;" + $data(configSelector("main-wrapper"), "value"));
            if (configSelector("head")) $style(BOX_HEAD, $data(configSelector("head"), "value"));
            if (configSelector("close")) $style(BOX_CLOSE_BTN, $data(configSelector("close"), "value"));
            if (configSelector("foot")) $style(BOX_FOOT, $data(configSelector("foot"), "value"));
            if (align) $style(BOX_BODY).textAlign = align; else if (configSelector("box-body-align")) $style(BOX_BODY).textAlign = $data(configSelector("box-body-align"), "value"); else $style(BOX_BODY).textAlign = "inherit";
            if (configSelector("body")) $style(BOX_BODY, $data(configSelector("body"), "value"));
            setTimeout(() => $class(BOX_WRAPPER, "add", "osai-modal__appear"), 100);

            if(!closeOnBlur) {
                let overlayClose = configSelector("close-on-blur") ? $data(configSelector("close-on-blur"), "value") : undefined;

                if ($type(overlayClose) === "String")
                    closeOnBlur = JSON.parse(overlayClose);
                else if ($type(overlayClose) === "Boolean")
                    closeOnBlur = overlayClose;
            }

            let closeHandler = () => BOX_CLOSE(onClose)

            if (closeOnBlur === true)
                $on(BOX_OVERLAY, "click", closeHandler);
            else
                $on(BOX_OVERLAY, "click", closeHandler, "del");

            $on(BOX_CLOSE_BTN, "click", closeHandler, "on");

            $on(BOX_FOOT, "click", e => {
                e.preventDefault();
                if ($class(e.target, "has", "osai-close-box")) closeHandler();
                else if ($class(e.target.parentNode, "has", "osai-close-box")) closeHandler();
            }, "on");
            $on($doc, "keydown", e => {
                if (e.keyCode === 27) {
                    e.preventDefault();
                    closeHandler();
                }
            }, "on");
        };
        const BOX_FLUSH = (where = "*") => {
            switch (where) {
              case "head":
                $html(BOX_HEAD, "in", "");
                $style(BOX_HEAD, "min-height: 0;");
                break;

              case "body":
                $html(BOX_BODY, "in", "");
                break;

              case "foot":
                $html(BOX_FOOT, "in", "");
                break;

              default:
                $html(BOX_HEAD, "in", "");
                $html(BOX_BODY, "in", "");
                $html(BOX_FOOT, "in", "");
                break;
            }
            return this;
        };
        const BOX_INSERT = (where, text = "") => {
            switch (where) {
              case "head":
                where = BOX_HEAD;
                $style(BOX_HEAD, "del");
                break;

              case "body":
                where = BOX_BODY;
                break;

              case "foot":
                where = BOX_FOOT;
                break;

              case "head+":
                where = BOX_HEAD;
                $style(BOX_HEAD, "del");
                text = $html(BOX_HEAD) + text;
                break;

              case "body+":
                where = BOX_BODY;
                text = $html(BOX_BODY) + text;
                break;

              case "foot+":
                where = BOX_FOOT;
                text = $html(BOX_FOOT) + text;
                break;

              default:
                return;
            }
            $html(where, "in", text);
        };
        const BOX_CLOSE = callbackFn => {
            BOX_VIEW("close");
            $style(BOX_OVERLAY, "display:none");
            $on(BOX_OVERLAY, "click", () => BOX_CLOSE(callbackFn), false, "del");
            $class(BOX_WRAPPER, "del", "osai-modal__appear");
            setTimeout(() => {
                $style(BOX_WRAPPER, "display: none;");
                BOX_FLUSH();
            }, 250);
            if ($type(callbackFn) === "Function") callbackFn();
            return false;
        };
        const BOX_ACTION = (actionFunction, closeOnDone = true, onClose = (() => null)) => {
            actionFunction();
            if (closeOnDone) BOX_CLOSE(onClose);
        };
        dialog = {
            render: (closeOnBlur, size, align, onClose) => {
                BOX_RENDER(closeOnBlur, size, align, onClose);
                return dialog;
            },
            flush: (where = "*") => {
                BOX_FLUSH(where);
                return dialog;
            },
            get: {
                head: BOX_HEAD,
                foot: BOX_FOOT,
                wrapper: BOX_INNER_WRAPPER,
                wrap: BOX_INNER_WRAPPER,
                body: BOX_BODY
            },
            config: ({align: align, size: size, closeOnBlur: closeOnBlur, wrapper: wrapper, head: head, foot: foot, body: body, close: close}) => {
                let addConfig = (config, value) => {
                    let element = config => $sel("input[data-config='" + config + "'].osai-dialogbox__config");
                    if (!element(config)) $html(BOX_PRESENCE, "beforeend", `<input type="hidden" class="osai-dialogbox__config" data-config="${config}" data-value="${value}">`); else $data(element(config), "value", value);
                };
                if (align) addConfig("box-body-align", align);
                if (size) addConfig("box-size", size);
                if (wrapper) addConfig("main-wrapper", wrapper);
                if (head) addConfig("head", head);
                if (body) addConfig("body", body);
                if (foot) addConfig("foot", foot);
                if (close) addConfig("close", close);
                if ($type(closeOnBlur) === "String" || $type(closeOnBlur) === "Boolean") addConfig("close-on-blur", closeOnBlur);
            },
            insert: (where, text = "") => {
                BOX_INSERT(where, text);
                return dialog;
            },
            closeBox: (onClose = (() => null)) => {
                BOX_CLOSE(onClose);
                return dialog;
            },
            action: (operation, closeOnDone = true) => BOX_ACTION(operation, closeOnDone)
        };
    }
    if (boxToDraw === "all" || boxToDraw === "notifier" || boxToDraw === "notify") {
        if (!$in($sel(".osai-notifier__present"))) $html($sel("body"), "beforeend", `\n\t\t\t <span style="display: none" class="osai-notifier__present"></span>`);
        if (!$in($sel(".osai-notifier__stylesheet"))) $html($sel("head"), "beforeend", `<style class="osai-notifier__stylesheet" type="text/css" rel="stylesheet" media="all">\n\t\t\t.osai-notifier{\n\t\t\t\tscroll-behavior: smooth;\n\t\t\t\tposition: fixed;\n\t\t\t\ttop: 10px;\n\t\t\t\tright: 10px;\n\t\t\t\tborder-radius: 5px;\n\t\t\t\tpadding: 10px;\n\t\t\t\tfont-weight: 500;\n\t\t\t\tcolor: var(--dark-text);\n\t\t\t\tbackground-color: var(--dark-info);\n\t\t\t\tbox-shadow: 0 0 4px 0 var(--bg);\n\t\t\t\tdisplay:flex;\n\t\t\t\topacity: 0;\n\t\t\t\ttransform: translate(0,-50%);\n\t\t\t\tz-index: 16012;\n\t\t\t\tmin-height: 50px;\n\t\t\t\tmin-width: 100px;\n\t\t\t\tjustify-content: center;\n\t\t\t\talign-items: center;\n\t\t\t\tflex-flow: column;\n                transition: ease-in-out all .8s;\n\t\t\t}\n\t\t\t.osai-notifier__display{\n\t\t\t\topacity: 1;\n\t\t\t\ttransform: translate(0,0);\n\t\t\t\tmax-width: 50vw;\n\t\t\t}\n\t\t\t.osai-notifier__display-center{\n\t\t\t\ttop: 50%; \n\t\t\t\tleft: 50%;\n                right: auto;\n\t\t\t\ttransform: translate(-50%,-50%);\n\t\t\t} @media (max-width: 767px){\n                .osai-notifier__display-center{\n                    max-width: 60vw;\n                }}\n\t\t\t.osai-notifier__close{\n\t\t\t\tposition: absolute;\n\t\t\t\ttop: -4px;\n\t\t\t\tleft: -4px;\n\t\t\t\tfont-size: .7rem;\n\t\t\t\tfont-weight: bold;\n\t\t\t\tdisplay: flex;\n\t\t\t\tjustify-content: center;\n\t\t\t\talign-items: center;\n\t\t\t\tborder-radius: 50%;\n\t\t\t\tcolor: inherit;\n\t\t\t\tbackground: inherit;\n\t\t\t\tcursor: pointer;\n\t\t\t\topacity: .8;\n\t\t\t}\n\t\t\t.osai-notifier__close:hover{\n\t\t\t\topacity: 1;\n\t\t\t}\n\t\t\t.osai-notifier.success,.osai-notifier.fail,.osai-notifier.warn,.osai-notifier.info{\n\t\t\t\tcolor: var(--dark-text);\n\t\t\t\tbox-shadow: -1px -1px 4px 1px var(--dark-info);\n\t\t\t}\n\t\t\t.osai-notifier.success{\n\t\t\t\tbackground-color: var(--success);\n\t\t\t\tcolor: var(--bg);\n\t\t\t}\n\t\t\t.osai-notifier.fail{\n\t\t\t\tbackground-color: var(--fail);\n\t\t\t}\n\t\t\t.osai-notifier.warn{\n\t\t\t\tbackground-color: var(--warn);\n\t\t\t}\n\t\t\t.osai-notifier.info{\n\t\t\t\tbackground-color: var(--info);\n\t\t\t}\n\t\t\t.osai-notifier__body{\n\t\t\t\toverflow: auto;\n\t\t\t\tpadding: 5px;\n\t\t\t\tmargin: 5px auto;\n\t\t\t\tmax-width: 100%;\n\t\t\t}\n\t\t</style>`);
        const NOTIFY = (dialog, theme, options) => {
            if ($in($sel(".osai-notifier__present"))) {
                let position = options.position, styleClass = "", iconImg = "bell", postStyle = "";
                let uniqueId = options.id ? `id="${options.id}"` : "";
                if (position === "center") postStyle = " osai-notifier__display-center";
                switch (theme) {
                  case "success":
                  case "good":
                    styleClass = "success";
                    iconImg = "check-o";
                    break;

                  case "fail":
                  case "danger":
                  case "error":
                    styleClass = "fail";
                    iconImg = "close-o";
                    break;

                  case "info":
                    styleClass = "info";
                    iconImg = "bulb";
                    break;

                  case "warn":
                  case "warning":
                    styleClass = "warn";
                    iconImg = "danger";
                    break;

                  default:
                    styleClass = "";
                    break;
                }
                $html($sel("body"), "beforeend", `\n            <div class="osai-notifier osai-notifier-entry${postStyle} ${styleClass}" ${uniqueId}>\n\t\t\t\t<div class="osai-notifier__close gg-close"></div>\n\t\t\t\t<div class="osai-notifier__icon"><i class="gg-${iconImg}"></i></div>\n\t\t\t\t<div class="osai-notifier__body">${dialog}</div>\n\t\t\t</div>`);
                let notifyEntry = $sela(".osai-notifier-entry");
                notifyEntry.forEach((box, boxIndex) => {
                    let duration = options.duration || 5e3, topMargin = 0;
                    if (boxIndex > 0) topMargin = getTop(notifyEntry[boxIndex - 1], topMargin);
                    setTimeout(() => {
                        $class(box, "add", "osai-notifier__display");
                        if (!$class(box, "has", "osai-notifier__display-center")) addTop(topMargin, box);
                    }, 200);
                    if (!$class(box, "has", "osai-notifier__display")) removeNotifier();
                    $on($sel(".osai-notifier__close", box), "click", e => {
                        e.preventDefault();
                        removeNotifier(false);
                    });
                    function getTop(theElement, theTop) {
                        if (!$class(theElement, "has", "osai-notifier__display-center")) theTop += theElement.offsetHeight + parseInt($style(theElement, "css").top.replace("px", "")); else if ($class(theElement.previousElementSibling, "has", "osai-notifier__display") && !$class(theElement.previousElementSibling, "has", "osai-notifier__display-center")) theTop += getTop(theElement.previousElementSibling, theTop);
                        return theTop;
                    }
                    function addTop(margin, to, plus = 10) {
                        if (margin + plus === 0) $style(to, "top:10px"); else $style(to, "top:" + (margin + plus) + "px");
                    }
                    function adjustBox(presentBox, boxNextSibling, newTop = null) {
                        let presentTop;
                        if (boxNextSibling) {
                            presentTop = $style(boxNextSibling, "css").top.replace("px", "");
                            newTop = newTop || $style(presentBox, "css").top.replace("px", "");
                            if ($class(boxNextSibling, "has", "osai-notifier__display") && !$class(boxNextSibling, "has", "osai-notifier__display-center") && !$class(presentBox, "has", "osai-notifier__display-center")) {
                                addTop(parseInt(newTop), boxNextSibling, 0);
                                if (boxNextSibling.nextElementSibling) adjustBox(boxNextSibling, boxNextSibling.nextElementSibling, parseInt(presentTop));
                            }
                        }
                        return null;
                    }
                    function removeNotifier(useDuration = true) {
                        duration = useDuration ? duration : 0;
                        if (duration !== "pin" && duration !== "fixed") {
                            if (useDuration) {
                                setTimeout(() => $class(box, "del", "osai-notifier__display"), duration);
                                duration = duration + 50;
                            } else duration = 0;
                            setTimeout(() => {
                                adjustBox(box, box.nextElementSibling);
                                box.remove();
                            }, duration);
                        }
                    }
                });
                return $sel("body").lastChild;
            }
            console.error("OsAi Notifier could not be found, you probably didn't draw it's box");
            return false;
        };
        notifier = {
            notify: (dialog, theme, option) => NOTIFY(dialog, theme, option)
        };
    }
    return {
        ...dialog,
        ...notifier
    };
};

const CusWind = $osaiBox();

function aMsg(message, option = {
    showButton: true,
    closeOnBlur: null,
}) {
    CusWind.insert("body", message);
    if (option.showButton === false) CusWind.flush("head").flush("foot"); else CusWind.insert("head", "Alert Box").insert("foot", `<button type="button" class="success osai-modal__btn osai-close-box"><i class='gg-check'></i></button>`);
    CusWind.render(option.closeOnBlur);
}

function cMsg(message, operation, option = {
    closeOnDone: true,
    closeOnBlur: null,
}) {
    CusWind.insert("head", "Confirmation Box").insert("body", message).insert("foot", `<button type="button" class="success osai-modal__btn osai-confirm-success"><i class="gg-check"></i></button>\n\t\t<button type="button" class="fail osai-modal__btn osai-close-box"><i class="gg-close"></i></button>`).render(option.closeOnBlur);
    $on($sel(".osai-confirm-success"), "click", e => {
        e.preventDefault();
        CusWind.action(operation, option.closeOnDone);
    });
}

function pMsg(message = "Prompt Box", operation = (inputValue => inputValue), custom = {
    body: null,
    operation: null,
    closeOnDone: true,
    closeOnBlur: null,
}) {
    CusWind.insert("head", "Prompt Box").insert("body", "<div style='margin-bottom: 5px'>" + message + "</div>").insert("body+", custom.body || "<textarea class='osai-prompt-input-box' style='width: 100%; height: 50px; text-align: center' placeholder='Type in...'></textarea>").insert("foot", `<button type="button" class="success osai-modal__btn osai-confirm-success"><i class="gg-check"></i></button>\n\t\t<button type="button" class="fail osai-close-box osai-modal__btn"><i class="gg-close"></i></button>`).render(custom.closeOnBlur);
    $on($sel(".osai-confirm-success"), "click", e => {
        e.preventDefault();
        if ($sel(".osai-prompt-input-box")) {
            if ($sel(".osai-prompt-input-box").value) CusWind.action(() => operation($sel(".osai-prompt-input-box").value), custom.closeOnDone);
        } else CusWind.action(custom.operation, custom.closeOnDone);
    });
}

function osModal({head: head = "osModal", body: body = "Osai Modal Box Built With OMJ$", foot: foot = "", operation: operation = (() => null), closeOnBlur: closeOnBlur, append: append = false, size: size, align: align, onClose: onClose = (() => null)}) {
    CusWind.insert("head", head).insert(append === true ? "body+" : "body", body).insert("foot", foot || `<button type="button" class="fail osai-close-box osai-modal__btn"><i class="gg-close-o"></i></button>`).render(closeOnBlur, size, align, onClose);
    return operation();
}

function osNote(message = "Hello, this is osNote", type = "", option = {
    duration: 5e3,
    position: "side"
}) {
    CusWind.notify(message, type, option);
}