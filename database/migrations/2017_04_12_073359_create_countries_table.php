<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code_2', 255);
			$table->string('code_3', 255)->nullable();
			$table->string('name', 255);
		});

		$countries = array(
		  array('code_2' => 'AF','code_3' => 'AFG','name' => 'Afghanistan'),
		  array('code_2' => 'AL','code_3' => 'ALB','name' => 'Albania'),
		  array('code_2' => 'DZ','code_3' => 'DZA','name' => 'Algeria'),
		  array('code_2' => 'AS','code_3' => 'ASM','name' => 'American Samoa'),
		  array('code_2' => 'AD','code_3' => 'AND','name' => 'Andorra'),
		  array('code_2' => 'AO','code_3' => 'AGO','name' => 'Angola'),
		  array('code_2' => 'AI','code_3' => 'AIA','name' => 'Anguilla'),
		  array('code_2' => 'AR','code_3' => 'ARG','name' => 'Argentina'),
		  array('code_2' => 'AM','code_3' => 'ARM','name' => 'Armenia'),
		  array('code_2' => 'AW','code_3' => 'ABW','name' => 'Aruba'),
		  array('code_2' => 'AU','code_3' => 'AUS','name' => 'Australia'),
		  array('code_2' => 'AT','code_3' => 'AUT','name' => 'Austria'),
		  array('code_2' => 'AZ','code_3' => 'AZE','name' => 'Azerbaijan'),
		  array('code_2' => 'BS','code_3' => 'BHS','name' => 'Bahamas'),
		  array('code_2' => 'BH','code_3' => 'BHR','name' => 'Bahrain'),
		  array('code_2' => 'BD','code_3' => 'BGD','name' => 'Bangladesh'),
		  array('code_2' => 'BB','code_3' => 'BRB','name' => 'Barbados'),
		  array('code_2' => 'BY','code_3' => 'BLR','name' => 'Belarus'),
		  array('code_2' => 'BE','code_3' => 'BEL','name' => 'Belgium'),
		  array('code_2' => 'BZ','code_3' => 'BLZ','name' => 'Belize'),
		  array('code_2' => 'BJ','code_3' => 'BEN','name' => 'Benin'),
		  array('code_2' => 'BM','code_3' => 'BMU','name' => 'Bermuda'),
		  array('code_2' => 'BT','code_3' => 'BTN','name' => 'Bhutan'),
		  array('code_2' => 'BO','code_3' => 'BOL','name' => 'Bolivia'),
		  array('code_2' => 'BA','code_3' => 'BIH','name' => 'Bosnia and Herzegovina'),
		  array('code_2' => 'BW','code_3' => 'BWA','name' => 'Botswana'),
		  array('code_2' => 'BR','code_3' => 'BRA','name' => 'Brazil'),
		  array('code_2' => 'BN','code_3' => 'BRN','name' => 'Brunei Darussalam'),
		  array('code_2' => 'BG','code_3' => 'BGR','name' => 'Bulgaria'),
		  array('code_2' => 'BF','code_3' => 'BFA','name' => 'Burkina Faso'),
		  array('code_2' => 'BI','code_3' => 'BDI','name' => 'Burundi'),
		  array('code_2' => 'KH','code_3' => 'KHM','name' => 'Cambodia'),
		  array('code_2' => 'CM','code_3' => 'CMR','name' => 'Cameroon'),
		  array('code_2' => 'CA','code_3' => 'CAN','name' => 'Canada'),
		  array('code_2' => 'CV','code_3' => 'CPV','name' => 'Cape Verde'),
		  array('code_2' => 'KY','code_3' => 'CYM','name' => 'Cayman Islands'),
		  array('code_2' => 'CF','code_3' => 'CAF','name' => 'Central African Republic'),
		  array('code_2' => 'TD','code_3' => 'TCD','name' => 'Chad'),
		  array('code_2' => 'CL','code_3' => 'CHL','name' => 'Chile'),
		  array('code_2' => 'CN','code_3' => 'CHN','name' => 'China'),
		  array('code_2' => 'CX','code_3' => NULL,'name' => 'Christmas Islands'),
		  array('code_2' => 'CC','code_3' => NULL,'name' => 'Cocos Islands'),
		  array('code_2' => 'CO','code_3' => 'COL','name' => 'Colombia'),
		  array('code_2' => 'KM','code_3' => 'COM','name' => 'Comoros'),
		  array('code_2' => 'CG','code_3' => 'COG','name' => 'Congo'),
		  array('code_2' => 'CD','code_3' => 'COD','name' => 'Democratic Republic of Congo'),
		  array('code_2' => 'CK','code_3' => 'COK','name' => 'Cook Islands'),
		  array('code_2' => 'CR','code_3' => 'CRI','name' => 'Costa Rica'),
		  array('code_2' => 'HR','code_3' => 'HRV','name' => 'Croatia'),
		  array('code_2' => 'CU','code_3' => 'CUB','name' => 'Cuba'),
		  array('code_2' => 'CY','code_3' => 'CYP','name' => 'Cyprus'),
		  array('code_2' => 'CZ','code_3' => 'CZE','name' => 'Czech Republic'),
		  array('code_2' => 'DK','code_3' => 'DNK','name' => 'Denmark'),
		  array('code_2' => 'DJ','code_3' => 'DJI','name' => 'Djibouti'),
		  array('code_2' => 'DM','code_3' => 'DMA','name' => 'Dominica'),
		  array('code_2' => 'DO','code_3' => 'DOM','name' => 'Dominican Republic'),
		  array('code_2' => 'EC','code_3' => 'ECU','name' => 'Ecuador'),
		  array('code_2' => 'EG','code_3' => 'EGY','name' => 'Egypt'),
		  array('code_2' => 'SV','code_3' => 'SLV','name' => 'El Salvador'),
		  array('code_2' => 'GQ','code_3' => 'GNQ','name' => 'Equatorial Guinea'),
		  array('code_2' => 'ER','code_3' => 'ERI','name' => 'Eritrea'),
		  array('code_2' => 'EE','code_3' => 'EST','name' => 'Estonia'),
		  array('code_2' => 'ET','code_3' => 'ETH','name' => 'Ethiopia'),
		  array('code_2' => 'FK','code_3' => 'FLK','name' => 'Falkland Islands'),
		  array('code_2' => 'FO','code_3' => 'FRO','name' => 'Faroe Islands'),
		  array('code_2' => 'FJ','code_3' => 'FJI','name' => 'Fiji'),
		  array('code_2' => 'FI','code_3' => 'FIN','name' => 'Finland'),
		  array('code_2' => 'FR','code_3' => 'FRA','name' => 'France'),
		  array('code_2' => 'GF','code_3' => 'GUF','name' => 'French Guiana'),
		  array('code_2' => 'PF','code_3' => 'PYF','name' => 'French Polynesia'),
		  array('code_2' => 'GA','code_3' => 'GAB','name' => 'Gabon'),
		  array('code_2' => 'GM','code_3' => 'GMB','name' => 'Gambia'),
		  array('code_2' => 'GE','code_3' => 'GEO','name' => 'Georgia'),
		  array('code_2' => 'DE','code_3' => 'DEU','name' => 'Germany'),
		  array('code_2' => 'GH','code_3' => 'GHA','name' => 'Ghana'),
		  array('code_2' => 'GI','code_3' => 'GIB','name' => 'Gibraltar'),
		  array('code_2' => 'GR','code_3' => 'GRC','name' => 'Greece'),
		  array('code_2' => 'GL','code_3' => 'GRL','name' => 'Greenland'),
		  array('code_2' => 'GD','code_3' => 'GRD','name' => 'Grenada'),
		  array('code_2' => 'GP','code_3' => 'GLP','name' => 'Guadeloupe'),
		  array('code_2' => 'GU','code_3' => 'GUM','name' => 'Guam'),
		  array('code_2' => 'GT','code_3' => 'GTM','name' => 'Guatemala'),
		  array('code_2' => 'GN','code_3' => 'GIN','name' => 'Guinea'),
		  array('code_2' => 'GW','code_3' => 'GNB','name' => 'Guinea-Bissau'),
		  array('code_2' => 'GY','code_3' => 'GUY','name' => 'Guyana'),
		  array('code_2' => 'HT','code_3' => 'HTI','name' => 'Haiti'),
		  array('code_2' => 'HN','code_3' => 'HND','name' => 'Honduras'),
		  array('code_2' => 'HK','code_3' => 'HKG','name' => 'Hong Kong'),
		  array('code_2' => 'HU','code_3' => 'HUN','name' => 'Hungary'),
		  array('code_2' => 'IS','code_3' => 'ISL','name' => 'Iceland'),
		  array('code_2' => 'IN','code_3' => 'IND','name' => 'India'),
		  array('code_2' => 'ID','code_3' => 'IDN','name' => 'Indonesia'),
		  array('code_2' => 'IQ','code_3' => 'IRQ','name' => 'Iraq'),
		  array('code_2' => 'IE','code_3' => 'IRL','name' => 'Ireland'),
		  array('code_2' => 'IT','code_3' => 'ITA','name' => 'Italy'),
		  array('code_2' => 'CI','code_3' => 'CIV','name' => 'Ivory Coast'),
		  array('code_2' => 'JM','code_3' => 'JAM','name' => 'Jamaica'),
		  array('code_2' => 'JP','code_3' => 'JPN','name' => 'Japan'),
		  array('code_2' => 'JO','code_3' => 'JOR','name' => 'Jordan'),
		  array('code_2' => 'KZ','code_3' => 'KAZ','name' => 'Kazakhstan'),
		  array('code_2' => 'KE','code_3' => 'KEN','name' => 'Kenya'),
		  array('code_2' => 'KI','code_3' => 'KIR','name' => 'Kiribati'),
		  array('code_2' => 'KW','code_3' => 'KWT','name' => 'Kuwait'),
		  array('code_2' => 'KG','code_3' => 'KGZ','name' => 'Kyrgyzstan'),
		  array('code_2' => 'LA','code_3' => 'LAO','name' => 'Laos'),
		  array('code_2' => 'LV','code_3' => 'LVA','name' => 'Latvia'),
		  array('code_2' => 'LB','code_3' => 'LBN','name' => 'Lebanon'),
		  array('code_2' => 'LS','code_3' => 'LSO','name' => 'Lesotho'),
		  array('code_2' => 'LR','code_3' => 'LBR','name' => 'Liberia'),
		  array('code_2' => 'LY','code_3' => 'LBY','name' => 'Libya'),
		  array('code_2' => 'LI','code_3' => 'LIE','name' => 'Liechtenstein'),
		  array('code_2' => 'LT','code_3' => 'LTU','name' => 'Lithuania'),
		  array('code_2' => 'LU','code_3' => 'LUX','name' => 'Luxembourg'),
		  array('code_2' => 'MO','code_3' => 'MAC','name' => 'Macau'),
		  array('code_2' => 'MK','code_3' => 'MKD','name' => 'Macedonia'),
		  array('code_2' => 'MG','code_3' => 'MDG','name' => 'Madagascar'),
		  array('code_2' => 'MW','code_3' => 'MWI','name' => 'Malawi'),
		  array('code_2' => 'MY','code_3' => 'MYS','name' => 'Malaysia'),
		  array('code_2' => 'MV','code_3' => 'MDV','name' => 'Maldives'),
		  array('code_2' => 'ML','code_3' => 'MLI','name' => 'Mali'),
		  array('code_2' => 'MT','code_3' => 'MLT','name' => 'Malta'),
		  array('code_2' => 'MH','code_3' => 'MHL','name' => 'Marshall Islands'),
		  array('code_2' => 'MQ','code_3' => 'MTQ','name' => 'Martinique'),
		  array('code_2' => 'MR','code_3' => 'MRT','name' => 'Mauritania'),
		  array('code_2' => 'MU','code_3' => 'MUS','name' => 'Mauritius'),
		  array('code_2' => 'MX','code_3' => 'MEX','name' => 'Mexico'),
		  array('code_2' => 'FM','code_3' => 'FSM','name' => 'Micronesia'),
		  array('code_2' => 'MD','code_3' => 'MDA','name' => 'Moldova'),
		  array('code_2' => 'MC','code_3' => 'MCO','name' => 'Monaco'),
		  array('code_2' => 'MN','code_3' => 'MNG','name' => 'Mongolia'),
		  array('code_2' => 'MS','code_3' => 'MSR','name' => 'Montserrat'),
		  array('code_2' => 'MA','code_3' => 'MAR','name' => 'Morocco'),
		  array('code_2' => 'MZ','code_3' => 'MOZ','name' => 'Mozambique'),
		  array('code_2' => 'MM','code_3' => 'MMR','name' => 'Myanmar/Burma'),
		  array('code_2' => 'NA','code_3' => 'NAM','name' => 'Namibia'),
		  array('code_2' => 'NR','code_3' => 'NRU','name' => 'Nauru'),
		  array('code_2' => 'NP','code_3' => 'NPL','name' => 'Nepal'),
		  array('code_2' => 'NL','code_3' => 'NLD','name' => 'Netherlands'),
		  array('code_2' => 'AN','code_3' => 'ANT','name' => 'Netherlands Antilles'),
		  array('code_2' => 'NC','code_3' => 'NCL','name' => 'New Caledonia'),
		  array('code_2' => 'NZ','code_3' => 'NZL','name' => 'New Zealand'),
		  array('code_2' => 'NI','code_3' => 'NIC','name' => 'Nicaragua'),
		  array('code_2' => 'NE','code_3' => 'NER','name' => 'Niger'),
		  array('code_2' => 'NG','code_3' => 'NGA','name' => 'Nigeria'),
		  array('code_2' => 'NU','code_3' => 'NIU','name' => 'Niue'),
		  array('code_2' => 'NF','code_3' => 'NFK','name' => 'Norfolk Island'),
		  array('code_2' => 'KP','code_3' => 'PRK','name' => 'North Korea'),
		  array('code_2' => 'NO','code_3' => 'NOR','name' => 'Norway'),
		  array('code_2' => 'OM','code_3' => 'OMN','name' => 'Oman'),
		  array('code_2' => 'PK','code_3' => 'PAK','name' => 'Pakistan'),
		  array('code_2' => 'PA','code_3' => 'PAN','name' => 'Panama'),
		  array('code_2' => 'PG','code_3' => 'PNG','name' => 'Papua New Guinea'),
		  array('code_2' => 'PY','code_3' => 'PRY','name' => 'Paraguay'),
		  array('code_2' => 'PE','code_3' => 'PER','name' => 'Peru'),
		  array('code_2' => 'PH','code_3' => 'PHL','name' => 'Philippines'),
		  array('code_2' => 'PL','code_3' => 'POL','name' => 'Poland'),
		  array('code_2' => 'PT','code_3' => 'PRT','name' => 'Portugal'),
		  array('code_2' => 'PR','code_3' => 'PRI','name' => 'Puerto Rico'),
		  array('code_2' => 'QA','code_3' => 'QAT','name' => 'Qatar'),
		  array('code_2' => 'RE','code_3' => 'REU','name' => 'Reunion, Island of'),
		  array('code_2' => 'RO','code_3' => 'ROM','name' => 'Romania'),
		  array('code_2' => 'RU','code_3' => 'RUS','name' => 'Russian Federation'),
		  array('code_2' => 'RW','code_3' => 'RWA','name' => 'Rwanda'),
		  array('code_2' => 'SH','code_3' => 'SHN','name' => 'Saint Helena'),
		  array('code_2' => 'KN','code_3' => 'KNA','name' => 'Saint Kitts and Nevis'),
		  array('code_2' => 'LC','code_3' => 'LCA','name' => 'Saint Lucia'),
		  array('code_2' => 'PM','code_3' => 'SPM','name' => 'Saint Pierre and Miquelon'),
		  array('code_2' => 'VC','code_3' => 'VCT','name' => 'Saint Vincent'),
		  array('code_2' => 'WS','code_3' => 'WSM','name' => 'Samoa'),
		  array('code_2' => 'SM','code_3' => 'SMR','name' => 'San Marino'),
		  array('code_2' => 'SN','code_3' => 'SEN','name' => 'Senegal'),
		  array('code_2' => 'CS','code_3' => NULL,'name' => 'Serbia and Montenegro'),
		  array('code_2' => 'SC','code_3' => 'SYC','name' => 'Seychelles'),
		  array('code_2' => 'SL','code_3' => 'SLE','name' => 'Sierra Leone'),
		  array('code_2' => 'SG','code_3' => 'SGP','name' => 'Singapore'),
		  array('code_2' => 'SK','code_3' => 'SVK','name' => 'Slovakia'),
		  array('code_2' => 'SI','code_3' => 'SVN','name' => 'Slovenia'),
		  array('code_2' => 'SB','code_3' => 'SLB','name' => 'Solomon Islands'),
		  array('code_2' => 'SO','code_3' => 'SOM','name' => 'Somalia'),
		  array('code_2' => 'ZA','code_3' => 'ZAF','name' => 'South Africa'),
		  array('code_2' => 'GS','code_3' => NULL,'name' => 'South Georgia and the South Sandwich Islands'),
		  array('code_2' => 'KR','code_3' => 'KOR','name' => 'South Korea'),
		  array('code_2' => 'ES','code_3' => 'ESP','name' => 'Spain'),
		  array('code_2' => 'LK','code_3' => 'LKA','name' => 'Sri Lanka'),
		  array('code_2' => 'SD','code_3' => 'SDN','name' => 'Sudan'),
		  array('code_2' => 'SR','code_3' => 'SUR','name' => 'Suriname'),
		  array('code_2' => 'SZ','code_3' => 'SWZ','name' => 'Swaziland'),
		  array('code_2' => 'SE','code_3' => 'SWE','name' => 'Sweden'),
		  array('code_2' => 'CH','code_3' => 'CHE','name' => 'Switzerland'),
		  array('code_2' => 'SY','code_3' => 'SYR','name' => 'Syria'),
		  array('code_2' => 'TW','code_3' => 'TWN','name' => 'Taiwan'),
		  array('code_2' => 'TJ','code_3' => 'TJK','name' => 'Tajikistan'),
		  array('code_2' => 'TZ','code_3' => 'TZA','name' => 'Tanzania'),
		  array('code_2' => 'TH','code_3' => 'THA','name' => 'Thailand'),
		  array('code_2' => 'TG','code_3' => 'TGO','name' => 'Togo'),
		  array('code_2' => 'TO','code_3' => 'TON','name' => 'Tonga'),
		  array('code_2' => 'TT','code_3' => 'TTO','name' => 'Trinidad and Tobago'),
		  array('code_2' => 'TN','code_3' => 'TUN','name' => 'Tunisia'),
		  array('code_2' => 'TR','code_3' => 'TUR','name' => 'Turkey'),
		  array('code_2' => 'TM','code_3' => 'TKM','name' => 'Turkmenistan'),
		  array('code_2' => 'UG','code_3' => 'UGA','name' => 'Uganda'),
		  array('code_2' => 'UA','code_3' => 'UKR','name' => 'Ukraine'),
		  array('code_2' => 'AE','code_3' => 'ARE','name' => 'United Arab Emirates'),
		  array('code_2' => 'GB','code_3' => 'GBR','name' => 'United Kingdom'),
		  array('code_2' => 'US','code_3' => 'USA','name' => 'United States'),
		  array('code_2' => 'UY','code_3' => 'URY','name' => 'Uruguay'),
		  array('code_2' => 'UZ','code_3' => 'UZB','name' => 'Uzbekistan'),
		  array('code_2' => 'VA','code_3' => 'VAT','name' => 'Vatican City'),
		  array('code_2' => 'VU','code_3' => 'VUT','name' => 'Vanuatu'),
		  array('code_2' => 'VE','code_3' => 'VEN','name' => 'Venezuela'),
		  array('code_2' => 'VN','code_3' => 'VNM','name' => 'Vietnam'),
		  array('code_2' => 'VG','code_3' => 'VGB','name' => 'Virgin Islands, British'),
		  array('code_2' => 'VI','code_3' => 'VIR','name' => 'Virgin Islands, U.s.'),
		  array('code_2' => 'WF','code_3' => 'WLF','name' => 'Wallis Islands'),
		  array('code_2' => 'YE','code_3' => 'YEM','name' => 'Yemen'),
		  array('code_2' => 'ZM','code_3' => 'ZMB','name' => 'Zambia'),
		  array('code_2' => 'ZW','code_3' => 'ZWE','name' => 'Zimbabwe'),
		  array('code_2' => 'SA','code_3' => 'SAU','name' => 'Saudi Arabia')
		);

		\App\Models\Countries::insert($countries);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('countries');
	}

}