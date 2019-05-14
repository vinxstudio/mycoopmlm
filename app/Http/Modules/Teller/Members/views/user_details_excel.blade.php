<?php
ini_set('max_execution_time', 5000);
ini_set('memory_limit','256M');
?>
<html>
    <body>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>E-mail</th>
                <th>Bank Name</th>
                <th>Bank Account Name</th>
                <th>Bank Account Number</th>
                <th>Truemoney Account Number</th>
                <th>Title</th>
                <th>Suffix</th>
                <th>Birthdate</th>
                <th>Birth Place</th>
                <th>Profession</th>
                <th>Gender</th>
                <th>Religion</th>
                <th>Nationality</th>
                <th>Present Address</th>
                <th>Provincial Address</th>
            </tr>
            @foreach($userinfos as $userinfo)
            <?php
                $id = (!empty($userinfo->id))? $userinfo->id : '';
                $first_name = (!empty($userinfo->first_name))? $userinfo->first_name : '';
                $middle_name = (!empty($userinfo->middle_name))? $userinfo->middle_name : '';
                $last_name = (!empty($userinfo->last_name))? $userinfo->last_name : '';
                $email = (!empty($userinfo->email))? $userinfo->email : '';
                $bank_name = (!empty($userinfo->bank_name))? $userinfo->bank_name : '';
                $account_name = (!empty($userinfo->account_name))? $userinfo->account_name : '';
                $account_number = (!empty($userinfo->account_number))? $userinfo->account_number : '';
                $truemoney = (!empty($userinfo->truemoney))? $userinfo->truemoney : '';
                $title = (!empty($userinfo->title))? $userinfo->title : '';
                $suffix = (!empty($userinfo->suffix))? $userinfo->suffix : '';
                $birth_date = (!empty($userinfo->birth_date))? $userinfo->birth_date : '';
                $birth_place = (!empty($userinfo->birth_place))? $userinfo->birth_place : '';
                $profession = (!empty($userinfo->profession))? $userinfo->profession : '';
                $gender = (!empty($userinfo->gender))? $userinfo->gender : '';
                $religion = (!empty($userinfo->religion))? $userinfo->religion : '';
                $nationality = (!empty($userinfo->nationality))? $userinfo->nationality : '';
                $present_street = (!empty($userinfo->present_street))? $userinfo->present_street : '';
                $present_barangay = (!empty($userinfo->present_barangay))? $userinfo->present_barangay : '';
                $present_town = (!empty($userinfo->present_town))? $userinfo->present_town : '';
                $present_city = (!empty($userinfo->present_city))? $userinfo->present_city : '';
                $present_province = (!empty($userinfo->present_province))? $userinfo->present_province : '';

                $provincial_barangay = (!empty($userinfo->provincial_barangay))? $userinfo->provincial_barangay : '';
                $provincial_town = (!empty($userinfo->provincial_town))? $userinfo->provincial_town : '';
                $provincial_province = (!empty($userinfo->provincial_province))? $userinfo->provincial_province : '';
            ?>
            <tr>
                <td>{{ $id }}</td>
                <td>{{ $first_name }}</td>
                <td>{{ $middle_name }}</td>
                <td>{{ $last_name }}</td>
                <td>{{ $email }}</td>
                <td>{{ $bank_name }}</td>
                <td>{{ $account_name }}</td>
                <td>{{ $account_number }}</td>
                <td>{{ $truemoney }}</td>
                <td>{{ $title }}</td>
                <td>{{ $suffix }}</td>
                <td>{{ $birth_date }}</td>
                <td>{{ $birth_place }}</td>
                <td>{{ $profession }}</td>
                <td>{{ $gender }}</td>
                <td>{{ $religion }}</td>
                <td>{{ $nationality }}</td>
                <td>{{ $present_street.' '.$present_barangay.' '.$present_town.', '.$present_city.', '.$present_province }}</td>
                <td>{{ $provincial_barangay.' '.$provincial_town.', '.$provincial_province }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
