// TODO: Handle profile detials
// Circles, and ...

if($('.profile').length){
var url = Hi.baseurl() + 'public/view/explore_profile.htm';
$('.profile').load(url);
$('.jumbotron').remove();
}