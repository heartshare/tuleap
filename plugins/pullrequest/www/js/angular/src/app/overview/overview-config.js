angular
    .module('tuleap.pull-request')
    .config(OverviewConfig);

OverviewConfig.$inject = [
    '$stateProvider'
];

function OverviewConfig(
    $stateProvider
) {
    $stateProvider.state('overview', {
        url   : '/overview',
        parent: 'pull-request',
        views : {
            'overview@pull-request': {
                template: '<div overview id="overview"></div>'
            },
            'timeline@overview': {
                template: '<div timeline id="timeline"></div>'
            }
        }
    });
}
