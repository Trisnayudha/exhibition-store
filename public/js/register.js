
const hideSelection = () => {
    $(".selection_one, .selection_second, .selection_third, .selection_fourth, .selection_fifth, .selection_sixth, .selection_seventh, .selection_eighteen").hide()

}

const hideSelectionOther = () => {
    $("input[name='classify_minerals_other']").hide().val("").removeClass("validation")
    $("input[name='classify_mining_other']").hide().val("").removeClass("validation")
    $("input[name='commodities_minerals_other']").hide().val("").removeClass("validation")
    $("input[name='commodities_minerals_coal_other']").hide().val("").removeClass("validation")
    $("input[name='commodities_mining_other']").hide().val("").removeClass("validation")
    $("input[name='origin_manufacturer_other']").hide().val("").removeClass("validation")
}

const clearSelectionValue = () => {
    if ($("#classify_minerals").length) $("#classify_minerals").val("").trigger("change")
    if ($("#classify_mining").length) $("#classify_mining").val("").trigger("change")
    if ($("#project_type").length) $("#project_type").val("").trigger("change")
    if ($("#commodities_minerals").length) $("#commodities_minerals").val("").trigger("change")
    if ($("#commodities_minerals_coal").length) $("#commodities_minerals_coal").val("").trigger("change")
    if ($("#commodities_mining").length) $("#commodities_mining").val("").trigger("change")
    if ($("#origin_manufacturer").length) $("#origin_manufacturer").val("").trigger("change")

    if ($("#classify_minerals").length) $("#classify_minerals").removeClass("validation")
    if ($("#classify_mining").length) $("#classify_mining").removeClass("validation")
    if ($("#project_type").length) $("#project_type").removeClass("validation")
    if ($("#commodities_minerals").length) $("#commodities_minerals").removeClass("validation")
    if ($("#commodities_minerals_coal").length) $("#commodities_minerals_coal").removeClass("validation")
    if ($("#commodities_mining").length) $("#commodities_mining").removeClass("validation")
    if ($("#origin_manufacturer").length) $("#origin_manufacturer").removeClass("validation")
}

const checkIsValueNotEmpty = () => {
    setTimeout(() => {
        if ($("#company_category").val() !== "") $("#company_category").val($("#company_category").val()).trigger("change")
        if ($("#classify_minerals").val() !== "") $("#classify_minerals").val($("#classify_minerals").val()).trigger("change")
        if ($("#classify_mining").val() !== "") $("#classify_mining").val($("#classify_mining").val()).trigger("change")
        if ($("#project_type").val() !== "") $("#project_type").val($("#project_type").val()).trigger("change")
        if ($("#commodities_minerals").val() !== "") $("#commodities_minerals").val($("#commodities_minerals").val()).trigger("change")
        if ($("#commodities_minerals_coal").val() !== "") $("#commodities_minerals_coal").val($("#commodities_minerals_coal").val()).trigger("change")
        if ($("#commodities_mining").val() !== "") $("#commodities_mining").val($("#commodities_mining").val()).trigger("change")
        if ($("#origin_manufacturer").val() !== "") $("#origin_manufacturer").val($("#origin_manufacturer").val()).trigger("change")
    }, 1000)
}

$(document).ready(function () {
    hideSelection()
    hideSelectionOther()

    // if ($("#pic_prefix").length) {
    //     $("#pic_prefix").select2()
    // }
    // if ($("#company_type").length) {
    //     $("#company_type").select2()
    // }
    if ($("#phone_code").length) {
        $("#phone_code").select2()
    }
    // console.log('company')
    if ($("#company_category").length) {

        $("#company_category").select2()
            .on('change.select2', function (e) {
                const value = this.value;
                const name = $(this).find(':selected').data('name')
                selectCategory(name)
            })
            .on('select2:select', function (e) {
                const value = this.value;
                const name = $(this).find(':selected').data('name')
                selectCategory(name)
            })
    }
    if ($("#classify_minerals").length) {
        $("#classify_minerals").select2()
            .on('select2:select', function (e) {
                const value = this.value;
                $("input[name='classify_minerals_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='classify_minerals_other']").show().addClass("validation")
                }
            })
    }
    if ($("#classify_mining").length) {
        $("#classify_mining").select2()
            .on('select2:select', function (e) {
                const value = this.value;
                $("input[name='classify_mining_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='classify_mining_other']").show().addClass("validation")
                }
            })
    }
    if ($("#project_type").length) {
        $("#project_type").select2()
    }
    if ($("#commodities_minerals").length) {
        $("#commodities_minerals").select2()
            .on('select2:select', function (e) {
                const value = this.value;
                $("input[name='commodities_minerals_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='commodities_minerals_other']").show().addClass("validation")
                }
            })
    }
    if ($("#commodities_minerals_coal").length) {
        $("#commodities_minerals_coal").select2()
            .on('select2:select', function (e) {
                const value = this.value;
                $("input[name='commodities_minerals_coal_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='commodities_minerals_coal_other']").show().addClass("validation")
                }
            })
    }
    if ($("#commodities_mining").length) {
        $("#commodities_mining").select2()
            .on('select2:select', function (e) {
                const value = this.value;
                $("input[name='commodities_mining_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='commodities_mining_other']").show().addClass("validation")
                }
            })
    }
    if ($("#origin_manufacturer").length) {
        $("#origin_manufacturer").select2()
            .on('change', function (e) {
                const value = this.value;
                $("input[name='origin_manufacturer_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='origin_manufacturer_other']").show().addClass("validation")
                }
            })
            .on('select2:select', function (e) {
                const value = this.value;
                $("input[name='origin_manufacturer_other']").hide().val("").removeClass("validation")

                if (value === 'Other') {
                    $("input[name='origin_manufacturer_other']").show().addClass("validation")
                }
            })
    }

    if ($("#company_category").val() !== "") {
        checkIsValueNotEmpty()
    }
})

const checkInSameArray = (array, search_value) => {
    if (array.length > 0) {
        for (let i = 0; i < array.length; i++) {
            if (array[i] === search_value) return true
        }
    }
    return false
}

const selectCategory = async (value) => {
    // await clearSelectionValue()
    await hideSelection()
    const stateOne = ['Coal Mining', 'Coal Processing', 'Minerals Producer', 'Minerals Processing']
    if (await checkInSameArray(stateOne, value)) {
        if ($(".selection_one").length) $(".selection_one").show()
        if ($(".selection_one select").length) $(".selection_one select").addClass("validation")
    }

    const stateSecond = ['Coal Mining', 'Coal Processing', 'Minerals Producer', 'Minerals Processing']
    if (await checkInSameArray(stateSecond, value)) {
        if ($(".selection_second").length) $(".selection_second").show()
        if ($(".selection_second select").length) $(".selection_second select").addClass("validation")
    }

    const stateThird = ['Coal Mining', 'Coal Processing', 'Minerals Producer', 'Minerals Processing']
    if (await checkInSameArray(stateThird, value)) {
        if ($(".selection_third").length) $(".selection_third").show()
        if ($(".selection_third select").length) $(".selection_third select").addClass("validation")
    }

    const stateFourth = ['Minerals Producer']
    if (await checkInSameArray(stateFourth, value)) {
        if ($(".selection_fourth").length) $(".selection_fourth").show()
        if ($(".selection_fourth select").length) $(".selection_fourth select").addClass("validation")
    }

    const stateFifth = ['Minerals Processing']
    if (await checkInSameArray(stateFifth, value)) {
        if ($(".selection_fifth").length) $(".selection_fifth").show()
        if ($(".selection_fifth select").length) $(".selection_fifth select").addClass("validation")
    }

    const stateSixth = ['Coal Mining', 'Coal Processing']
    if (await checkInSameArray(stateSixth, value)) {
        if ($(".selection_sixth").length) $(".selection_sixth").show()
        if ($(".selection_sixth select").length) $(".selection_sixth select").addClass("validation")
    }

    const stateSeventh = ['Technology', 'Supplier / Distributor / Manufacturer']
    if (await checkInSameArray(stateSeventh, value)) {
        if ($(".selection_seventh").length) $(".selection_seventh").show()
        if ($(".selection_seventh select").length) $(".selection_seventh select").addClass("validation")
    }

    const stateEighth = ['Coal Mining', 'Coal Processing', 'Minerals Producer', 'Minerals Processing','Covid-19 Solution','Media','Logistics and Shipping','Investors','Financial Services','Contractor']
    if (await checkInSameArray(stateEighth, value)){
        if ($(".selection_eighteen").length) $(".selection_eighteen").show()
        if ($(".selection_eighteen select").length) $(".selection_eighteen select").addClass("validation")
    }
}

const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

const addValidation = (input, message = '') => {
    let inputHtml = $(input)
    const html = `
        <div class="error-message text-danger mt-1">${message}</div>
    `
    inputHtml.parent().append(html)
}

const removeValidation = (input) => {
    let inputHtml = $(input)
    let findInput = inputHtml.parent().find('.error-message')
    findInput.remove()
}

const validEmail = (email) => {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

const validURL = (str) => {
    const pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    return !!pattern.test(str);
}

const checkValidation = (input) => {
    let inputHtml = $(input)
    let nameAttr = inputHtml.attr('placeholder')
    nameAttr = nameAttr.replace("Input ", "")
    nameAttr = nameAttr.replace("your ", "")
    nameAttr = capitalizeFirstLetter(nameAttr)

    inputHtml.removeClass('invalid')
    removeValidation(input)

    if (inputHtml.val().trim() === '') {
        addValidation(input, nameAttr+' must be filled.')
        return false
    } else if (inputHtml.attr('type') === 'checkbox' && !inputHtml.is(':checked')) {
        addValidation(input, nameAttr+' must be selected.')
        return false
    } else if (inputHtml.attr('type') === 'radio' && !inputHtml.is(':checked')) {
        addValidation(input, nameAttr+' must be selected.')
        return false
    } else if (inputHtml.attr('type') === 'email' && inputHtml.attr('name') === 'company_email') {
        if (validEmail(inputHtml.val()) !== true) {
            addValidation(input, 'Please enter your business email address');
            return false;
        }
    } else if (inputHtml.attr('type') === 'email' && inputHtml.attr('name') === 'alternative_email') {
        if (validEmail(inputHtml.val()) !== true) {
            addValidation(input, nameAttr+' contains an invalid email address.');
            return false;
        }
    } else if (inputHtml.attr('type') === 'text' && inputHtml.attr('name') === 'company_website') {
        if (validURL(inputHtml.val()) !== true) {
            addValidation(input, nameAttr+' has a format that does not match the writing url.');
            return false;
        }
    }
    return true
}

const runValidation = (validation) => {
    let input = $(validation)
    for (let i = 0; i < input.length; i++) {
        if (checkValidation(input[i]) === false) {
            $(input[i]).addClass('invalid')
            $(input[i]).focus()
            return false
        }
    }

    return true
}

$(function () {
    $('form').submit(function (event) {
        let valid = runValidation('.validation')
        if(valid)
            event.returnValue = false;
        else
            event.preventDefault();

    })
})
