<?php
include 'header.php';
?>

<table style="width: 100%;">
    <tr>
        <td style="width: 50px;">
        </td>
        <td>
        <h2>Student Registration</h2>
        <form name="frmReg" action="StudentRegisterScr.php" method="post">
            <div class="">
                <label>Full Name</label>
                <input type="text" name="txtStuName" class="form-control" required>
            </div>
            <div class="">
                <label>Gender</label>
                <select name="stuGender" class="form-control" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>        
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="stuDOB" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Place of Birth</label>
                <input type="text" name="stuPOB" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="txtPhone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="stuAddr" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Faculty</label>
                <select name="cboFaculty" class="form-control" required>
                    <option value="1">Bussiness</option>
                    <option value="2">Finance and Banking</option>
                    <option value="3">Infomration Technology</option>
                </select>
            </div>
            <div class="form-group">
                <label>Generation</label>
                <select name="cboGeneration" class="form-control" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="form-group">
                <label>Semeser</label>
                <select name="cboSemester" class="form-control" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="form-group">
                <label>Year</label>
                <select name="cboYear" class="form-control" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div><br>
            <div class="form-group">
            <center>
            <input type="submit" value="Register"/>
            </center>
            </div>
    </form>
          
        </td>
        <td style="width: 50px;">
            
        </td>
    </tr>
</table>



<?php
include 'footer.php';
?>