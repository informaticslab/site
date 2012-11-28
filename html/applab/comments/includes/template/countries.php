<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }

$countries = "<select name='cmtx_country' title='" . CMTX_TITLE_COUNTRY . "'>
<option value='blank'>" . CMTX_TOP_COUNTRY . "</option>
<option value='blank'></option>
<option value='US'>US</option>
<option value='UK'>UK</option>
<option value='Ireland'>Ireland</option>
<option value='Canada'>Canada</option>
<option value='Australia'>Australia</option>
<option value='blank'></option>
<option value='Afghanistan'>Afghanistan</option>
<option value='Albania'>Albania</option>
<option value='Algeria'>Algeria</option>
<option value='Andorra'>Andorra</option>
<option value='Angola'>Angola</option>
<option value='Antarctica'>Antarctica</option>
<option value='Antigua'>Antigua</option>
<option value='Argentina'>Argentina</option>
<option value='Armenia'>Armenia</option>
<option value='Aruba'>Aruba</option>
<option value='Austria'>Austria</option>
<option value='Azerbaijan'>Azerbaijan</option>
<option value='Bahamas'>Bahamas</option>
<option value='Bahrain'>Bahrain</option>
<option value='Bangladesh'>Bangladesh</option>
<option value='Barbados'>Barbados</option>
<option value='Barbuda'>Barbuda</option>
<option value='Belarus'>Belarus</option>
<option value='Belgium'>Belgium</option>
<option value='Belize'>Belize</option>
<option value='Benin'>Benin</option>
<option value='Bermuda'>Bermuda</option>
<option value='Bhutan'>Bhutan</option>
<option value='Bolivia'>Bolivia</option>
<option value='Bosnia'>Bosnia</option>
<option value='Botswana'>Botswana</option>
<option value='Brazil'>Brazil</option>
<option value='BIO Territory'>BIO Territory</option>
<option value='British Virgin Islands'>British Virgin Islands</option>
<option value='Brunei'>Brunei</option>
<option value='Bulgaria'>Bulgaria</option>
<option value='Burkina Faso'>Burkina Faso</option>
<option value='Burma'>Burma</option>
<option value='Burundi'>Burundi</option>
<option value='Cambodia'>Cambodia</option>
<option value='Cameroon'>Cameroon</option>
<option value='Cayman Islands'>Cayman Islands</option>
<option value='Central African Rep.'>Central African Rep.</option>
<option value='Chad'>Chad</option>
<option value='Chile'>Chile</option>
<option value='China'>China</option>
<option value='Colombia'>Colombia</option>
<option value='Congo (Dem. Rep.)'>Congo (Dem. Rep.)</option>
<option value='Congo (Rep.)'>Congo (Rep.)</option>
<option value='Costa Rica'>Costa Rica</option>
<option value='Croatia'>Croatia</option>
<option value='Cuba'>Cuba</option>
<option value='Cyprus'>Cyprus</option>
<option value='Czech Republic'>Czech Republic</option>
<option value='Denmark'>Denmark</option>
<option value='Djibouti'>Djibouti</option>
<option value='Dominican Rep.'>Dominican Rep.</option>
<option value='Ecuador'>Ecuador</option>
<option value='Egypt'>Egypt</option>
<option value='El Salvador'>El Salvador</option>
<option value='Equatorial Guinea'>Equatorial Guinea</option>
<option value='Eritrea'>Eritrea</option>
<option value='Estonia'>Estonia</option>
<option value='Ethiopia'>Ethiopia</option>
<option value='Falkland Islands'>Falkland Islands</option>
<option value='Faroe Islands'>Faroe Islands</option>
<option value='Fiji'>Fiji</option>
<option value='Finland'>Finland</option>
<option value='France'>France</option>
<option value='Gabon'>Gabon</option>
<option value='Gambia'>Gambia</option>
<option value='Georgia'>Georgia</option>
<option value='Germany'>Germany</option>
<option value='Ghana'>Ghana</option>
<option value='Greece'>Greece</option>
<option value='Greenland'>Greenland</option>
<option value='Grenada'>Grenada</option>
<option value='Guadeloupe'>Guadeloupe</option>
<option value='Guatemala'>Guatemala</option>
<option value='Guernsey'>Guernsey</option>
<option value='Guineal'>Guinea</option>
<option value='Guinea-Bissau'>Guinea-Bissau</option>
<option value='Guyana'>Guyana</option>
<option value='Haiti'>Haiti</option>
<option value='Heard-Mcdonald'>Heard-McDonald</option>
<option value='Honduras'>Honduras</option>
<option value='Hong Kong'>Hong Kong</option>
<option value='Hungary'>Hungary</option>
<option value='Iceland'>Iceland</option>
<option value='India'>India</option>
<option value='Indonesia'>Indonesia</option>
<option value='Iran'>Iran</option>
<option value='Iraq'>Iraq</option>
<option value='Isle of Man'>Isle of Man</option>
<option value='Israel'>Israel</option>
<option value='Italy'>Italy</option>
<option value='Ivory Coast'>Ivory Coast</option>
<option value='Jamaica'>Jamaica</option>
<option value='Japan'>Japan</option>
<option value='Jersey'>Jersey</option>
<option value='Jordan'>Jordan</option>
<option value='Kazakhstan'>Kazakhstan</option>
<option value='Kenya'>Kenya</option>
<option value='Korea, North'>Korea, North</option>
<option value='Korea, South'>Korea, South</option>
<option value='Kuwait'>Kuwait</option>
<option value='Kyrgyzstan'>Kyrgyzstan</option>
<option value='Laos'>Laos</option>
<option value='Latvia'>Latvia</option>
<option value='Lebanon'>Lebanon</option>
<option value='Lesotho'>Lesotho</option>
<option value='Liberia'>Liberia</option>
<option value='Libya'>Libya</option>
<option value='Liechtenstein'>Liechtenstein</option>
<option value='Lithuania'>Lithuania</option>
<option value='Luxembourg'>Luxembourg</option>
<option value='Macedonia'>Macedonia</option>
<option value='Madagascar'>Madagascar</option>
<option value='Malawi'>Malawi</option>
<option value='Malaysia'>Malaysia</option>
<option value='Maldives'>Maldives</option>
<option value='Mali'>Mali</option>
<option value='Malta'>Malta</option>
<option value='Marshall Islands'>Marshall Islands</option>
<option value='Mauritania'>Mauritania</option>
<option value='Mauritius'>Mauritius</option>
<option value='Mexico'>Mexico</option>
<option value='Moldova'>Moldova</option>
<option value='Monaco'>Monaco</option>
<option value='Mongolia'>Mongolia</option>
<option value='Montenegro'>Montenegro</option>
<option value='Montserrat'>Montserrat</option>
<option value='Morocco'>Morocco</option>
<option value='Mozambique'>Mozambique</option>
<option value='Namibia'>Namibia</option>
<option value='Nepal'>Nepal</option>
<option value='Netherlands'>Netherlands</option>
<option value='New Zealand'>New Zealand</option>
<option value='Nicaragua'>Nicaragua</option>
<option value='Niger'>Niger</option>
<option value='Nigeria'>Nigeria</option>
<option value='Norfolk Island'>Norfolk Island</option>
<option value='Norway'>Norway</option>
<option value='Oman'>Oman</option>
<option value='Pakistan'>Pakistan</option>
<option value='Palestine'>Palestine</option>
<option value='Panama'>Panama</option>
<option value='Papua New Guinea'>Papua New Guinea</option>
<option value='Paraguay'>Paraguay</option>
<option value='Peru'>Peru</option>
<option value='Philippines'>Philippines</option>
<option value='Poland'>Poland</option>
<option value='Portugal'>Portugal</option>
<option value='Puerto Rico'>Puerto Rico</option>
<option value='Qatar'>Qatar</option>
<option value='Romania'>Romania</option>
<option value='Russia'>Russia</option>
<option value='Rwanda'>Rwanda</option>
<option value='Samoa'>Samoa</option>
<option value='San Marino'>San Marino</option>
<option value='Saudi Arabia'>Saudi Arabia</option>
<option value='Senegal'>Senegal</option>
<option value='Serbia'>Serbia</option>
<option value='Seychelles'>Seychelles</option>
<option value='Sierra Leone'>Sierra Leone</option>
<option value='Singapore'>Singapore</option>
<option value='Slovakia'>Slovakia</option>
<option value='Slovenia'>Slovenia</option>
<option value='Somalia'>Somalia</option>
<option value='South Africa'>South Africa</option>
<option value='Spain'>Spain</option> 
<option value='Sri Lanka'>Sri Lanka</option>
<option value='Sudan'>Sudan</option>
<option value='Suriname'>Suriname</option>
<option value='Swaziland'>Swaziland</option>
<option value='Sweden'>Sweden</option>
<option value='Switzerland'>Switzerland</option>
<option value='Syria'>Syria</option>
<option value='Taiwan'>Taiwan</option>
<option value='Tajikistan'>Tajikistan</option>
<option value='Tanzania'>Tanzania</option>
<option value='Thailand'>Thailand</option>
<option value='The Emirates'>The Emirates</option>
<option value='Togo'>Togo</option>
<option value='Trinidad-Tobago'>Trinidad-Tobago</option>
<option value='Tunisia'>Tunisia</option>
<option value='Turkey'>Turkey</option>
<option value='Turkmenistan'>Turkmenistan</option>
<option value='Uganda'>Uganda</option>
<option value='Ukraine'>Ukraine</option>
<option value='Uruguay'>Uruguay</option>
<option value='US Outlying Islands'>US Outlying Islands</option>
<option value='US Virgin Islands'>US Virgin Islands</option>
<option value='Uzbekistan'>Uzbekistan</option>
<option value='Vatican City'>Vatican City</option>
<option value='Venezuela'>Venezuela</option>
<option value='Vietnam'>Vietnam</option>
<option value='Western Sahara'>Western Sahara</option>
<option value='Yemen'>Yemen</option>
<option value='Zambia'>Zambia</option>
<option value='Zimbabwe'>Zimbabwe</option>
<option value='Other'>Other</option>
</select>";

?>