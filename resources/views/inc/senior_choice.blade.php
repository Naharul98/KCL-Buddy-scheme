<input class="form-check-input" id="seniorInput" type="radio" name="student_type" {{(old('student_type',$data['student_type']) == 'senior') ? 'checked' : ''}} required value="senior" onclick='displaySeniorInput();'>