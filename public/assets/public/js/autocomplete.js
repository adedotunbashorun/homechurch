function createAutoCompleteSearchProgress(inputSelector) {
    var wrapper = '<div class="autocomplete-spin-wrap"></div>';
    inputSelector.wrap(wrapper);
    $("<i class=\"icon-spinner icon-spin autocomplete-spinner\" style=\"display: none; \"></i>").insertAfter(inputSelector);
}

function multipleSelect(inputSelector, route, placeholder = 'select data', tags = false) {
    inputSelector.select2({
        placeholder: placeholder,
        minimumInputLength: 2,
        tags: tags,
        ajax: {
            url: route,
            dataType: 'json',
            data: function(params) {
                return {
                    query: $.trim(params.term)
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.value,
                            id: item.data
                        }
                    })
                };
            },
            cache: true
        }
    });
}

function autoCompleteInputLookup(inputSelector, valueSelector, route, saveInputText, notice) {
    saveInputText = (typeof saveInputText !== 'undefined') ? saveInputText : false;
    notice = (typeof notice !== 'undefined') ? notice : "No Results";

    createAutoCompleteSearchProgress(inputSelector);
    var spinner = inputSelector.parent().find(".autocomplete-spinner");

    inputSelector.on("change", function() {
        spinner.hide();
    });

    inputSelector.autocomplete({
        serviceUrl: route,
        minChars: 1,
        showNoSuggestionNotice: true,
        noSuggestionNotice: notice,
        onSearchStart: function() {
            if (spinner.length) spinner.show();
        },

        onSelect: function(suggestion) {
            if (spinner.length) spinner.hide();
            valueSelector.attr('value', suggestion.data);
        },
        onSearchComplete: function(query, suggestions) {
            if (saveInputText) {
                if (!suggestions.length) valueSelector.attr('value', query);
            }
        },
        onHide: function(container) {
            // if (container.context.children[0].className !== 'autocomplete-no-suggestion') {
            valueSelector.attr('value', 0);
            this.value = '';
            // }
        }
    });
}

function getSelectOnChange(inputSelector, route, divSelector, responseSelector, selectOptionName, responseName) {
    $(divSelector).hide();
    makeRequest('', route, divSelector, responseSelector, selectOptionName, responseName);
    $(inputSelector).change(function() {
        var id = $(this).val();
        makeRequest(id, route, divSelector, responseSelector, selectOptionName, responseName);
    });
}

function makeRequest(id, route, divSelector, responseSelector, selectOptionName, responseName) {
    $.ajax({
        url: route + id,
        type: 'get',
        dataType: 'json',
        success: function(response) {
            $(divSelector).show();
            $(responseSelector).empty();
            $(responseSelector).append(`<option value=''>-- Select ${selectOptionName} --</option>`)
            response[responseName].forEach((element, index) => {
                $(responseSelector).append("<option value='" + element.id + "'>" + element.name + "</option>");
            });
        }
    });
}