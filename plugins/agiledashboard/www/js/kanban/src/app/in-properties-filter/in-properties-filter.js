angular
    .module('kanban')
    .filter('InPropertiesFilter', InPropertiesFilter);

InPropertiesFilter.$inject = ['$filter'];

function InPropertiesFilter($filter) {
    var amCalendarFilter = $filter('amCalendar');

    return function(list, terms) {
        if (! terms || terms === '') {
            return _.clone(list);
        }

        var properties    = ['id', 'label'],
            keywords      = terms.split(' '),
            filtered_list = list;

        keywords.forEach(function(keyword) {
            var regexp = new RegExp(keyword, 'gi');

            filtered_list = $filter('filter')(filtered_list, function (item) {
                if (properties.some(function (property) {
                    return match(item[property]);
                })) {
                    return true;
                }

                return item.card_fields.some(function (card_field) {
                    if (! card_field) {
                        return false;
                    }

                    switch (card_field.type) {
                        case 'sb':
                        case 'rb':
                        case 'cb':
                        case 'tbl':
                        case 'msb':
                        case 'shared':
                            return card_field.values.some(function (value) {
                                if (typeof value.display_name !== 'undefined') {
                                    return match(value.display_name);
                                }
                                return match(value.label);
                            });
                        case 'string':
                        case 'text':
                        case 'int':
                        case 'float':
                        case 'aid':
                        case 'atid':
                        case 'priority':
                            return match(card_field.value);
                        case 'file':
                            return card_field.file_descriptions.some(function (file) {
                              return match(file.name);
                            });
                        case 'cross':
                            return card_field.value.some(function (link) {
                                return match(link.ref);
                            });
                        case 'perm':
                            return card_field.granted_groups.some(function (group) {
                                return match(group);
                            });
                        case 'subby':
                        case 'luby':
                            return match(card_field.value.display_name);
                        case 'date':
                        case 'lud':
                        case 'subon':
                            return match(amCalendarFilter(card_field.value));
                        case 'computed':
                            if (card_field.manual_value !== null) {
                                return match(card_field.manual_value);
                            }
                            return match(card_field.value);
                    }

                    return false;
                });

                function match(value) {
                    return (""+value).match(regexp);
                }
            });
        });

        return filtered_list;
    };
}
