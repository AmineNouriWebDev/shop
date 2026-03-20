<?php
function switch_jour($jour)
{
   switch ($jour){
	case "1":
	return "Lundi";
	break;
	case "2":
	return "Mardi";
	break;
	case "3":
	return "Mercredi";
	break;
	case "4":
	return "Jeudi";
	break;
	case "5":
	return "Vendredi";
	break;
	case "6":
	return "Samedi";
	break;
	case "0":
	return "Dimanche";
	break;
	}
}

function switch_mois($mos)
{
   switch ($mos){
	case "1":
	return "Janvier";
	break;
	case "2":
	return "Février";
	break;
	case "3":
	return "Mars";
	break;
	case "4":
	return "Avril";
	break;
	case "5":
	return "mai";
	break;
	case "6":
	return "Juin";
	break;
	case "7":
	return "Juillet";
	break;
	case "8":
	return "Août";
	break;
	case "9":
	return "Septembre";
	break;
	case "10":
	return "Octobre";
	break;
	case "11":
	return "Novembre";
	break;
	case "12":
	return "Décembre";
	break;
	}
}

function switch_mois_en($mos)
{
   switch ($mos){
	case "1":
	return "January";
	break;
	case "2":
	return "February";
	break;
	case "3":
	return "March";
	break;
	case "4":
	return "April";
	break;
	case "5":
	return "May";
	break;
	case "6":
	return "June";
	break;
	case "7":
	return "July";
	break;
	case "8":
	return "August";
	break;
	case "9":
	return "September";
	break;
	case "10":
	return "October";
	break;
	case "11":
	return "November";
	break;
	case "12":
	return "December";
	break;
	}
}

function switch_abrv_mois($mos)
{
   switch ($mos){
	case "1":
	return "Janv";
	break;
	case "2":
	return "Févr";
	break;
	case "3":
	return "Mars";
	break;
	case "4":
	return "Avr";
	break;
	case "5":
	return "Mai";
	break;
	case "6":
	return "Juin";
	break;
	case "7":
	return "Juil";
	break;
	case "8":
	return "Août";
	break;
	case "9":
	return "Sept";
	break;
	case "10":
	return "Oct";
	break;
	case "11":
	return "Nov";
	break;
	case "12":
	return "Déc";
	break;
	}
}

function switch_abrv_mois_en($mos)
{
   switch ($mos){
	case "1":
	return "Jan";
	break;
	case "2":
	return "Feb";
	break;
	case "3":
	return "Mar";
	break;
	case "4":
	return "Apr";
	break;
	case "5":
	return "May";
	break;
	case "6":
	return "Jun";
	break;
	case "7":
	return "Jul";
	break;
	case "8":
	return "Aug";
	break;
	case "9":
	return "Sep";
	break;
	case "10":
	return "Oct";
	break;
	case "11":
	return "Nov";
	break;
	case "12":
	return "Dec";
	break;
	}
}

function switch_notification($notification)
{
   switch ($notification){
	case "1":
	return "Oui";
	break;
	case "0":
	return "Non";
	break;
	}
}
function switch_source($source)
{
   switch ($source){
	case "1":
	return "Client Boutique";
	break;
	case "2":
	return "Client Facebook";
	break;
	case "3":
	return "Client Zakat";
	break;
	}
}

?>