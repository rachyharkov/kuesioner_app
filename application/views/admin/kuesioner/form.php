<style>
	
#option-choice-slider {
  display: flex;
  flex-direction: row;
  align-content: stretch;
  position: relative;
  width: 100%;
  height: 50px;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
#option-choice-slider::before {
  content: " ";
  position: absolute;
  height: 2px;
  width: 100%;
  width: calc(100% * (4 / 5));
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #000;
}
#option-choice-slider input,
#option-choice-slider label {
  box-sizing: border-box;
  flex: 1;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  cursor: pointer;
}
#option-choice-slider label {
  display: inline-block;
  position: relative;
  width: 20%;
  height: 100%;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
#option-choice-slider label::before {
  content: attr(data-option-choice);
  position: absolute;
  left: 50%;
  padding-top: 10px;
  transform: translate(-50%, 45px);
  font-size: 14px;
  letter-spacing: 0.4px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0.85;
  transition: all 0.15s ease-in-out;
}
#option-choice-slider label::after {
  content: " ";
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 30px;
  height: 30px;
  border: 2px solid #000;
  background: #fff;
  border-radius: 50%;
  pointer-events: none;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  z-index: 1;
  cursor: pointer;
  transition: all 0.15s ease-in-out;
}
#option-choice-slider label:hover::after {
  transform: translate(-50%, -50%) scale(1.25);
}
#option-choice-slider input {
  display: none;
}
#option-choice-slider input:checked + #option-choice-slider label::before {
  font-weight: 800;
  opacity: 1;
}
#option-choice-slider input:checked + #option-choice-slider label::after {
  border-width: 4px;
  transform: translate(-50%, -50%) scale(0.75);
}
#option-choice-slider input:checked ~ #option-choice-pos {
  opacity: 1;
}
#option-choice-slider input:checked:nth-child(1) ~ #option-choice-pos {
  left: 13%;
}
#option-choice-slider input:checked:nth-child(3) ~ #option-choice-pos {
  left: 40%;
}
#option-choice-slider input:checked:nth-child(5) ~ #option-choice-pos {
  left: 60%;
}
#option-choice-slider input:checked:nth-child(7) ~ #option-choice-pos {
  left: 90%;
}
#option-choice-slider #option-choice-pos {
  display: block;
  position: absolute;
  top: 50%;
  width: 12px;
  height: 12px;
  background: #000;
  border-radius: 50%;
  transition: all 0.15s ease-in-out;
  transform: translate(-50%, -50%);
  border: 2px solid #fff;
  opacity: 0;
  z-index: 2;
}
#option-choice-slider input + #option-choice-slider label::before {
  transform: translate(-50%, 45px) scale(0.9);
  transition: all 0.15s linear;
}
#option-choice-slider input:checked + #option-choice-slider label::before {
  transform: translate(-50%, 45px) scale(1.1);
  transition: all 0.15s linear;
}

</style>

<form>
  <div class="mb-3">
    <label for="labelInputJudulKuesioner" class="form-label">Judul</label>
    <input type="text" class="form-control" id="labelInputJudulKuesioner">
  </div>
  <div class="mb-3">
    <label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
    <input type="text" class="form-control" id="labelInputDeskripsiKuesioner">
  </div>
  <div class="mb-3">
  	<table class="table">
	  <thead>
	    <tr>
	      <th>No</th>
	      <th>Pertanyaan</th>
	      <th>Harapan</th>
	      <th>Pengalaman yang Dirasakan</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td>1</td>
	      <td>
	      	<textarea name="pertanyaan[]" rows="4" cols="40"></textarea>
	      </td>
	      <td width="300">	
	      	<div id="option-choice-slider">
				<input type="radio" name="option-choice" id="pertanyaan1_col1_1" value="1" required>
				<label for="pertanyaan1_col1_1" data-option-choice="STS"></label>
				<input type="radio" name="option-choice" id="pertanyaan1_col1_2" value="2" required>
				<label for="pertanyaan1_col1_2" data-option-choice="TS"></label>
				<input type="radio" name="option-choice" id="pertanyaan1_col1_3" value="3" required>
				<label for="pertanyaan1_col1_3" data-option-choice="S"></label>
				<input type="radio" name="option-choice" id="pertanyaan1_col1_4" value="4" required>
				<label for="pertanyaan1_col1_4" data-option-choice="SS"></label>
				<div id="option-choice-pos"></div>
			</div>

	      </td>
	      <td width="300">	
	      	<div id="option-choice-slider">
				<input type="radio" name="option-choice" id="pertanyaan1_col2_1" value="1" required>
				<label for="pertanyaan1_col2_1" data-option-choice="STS"></label>
				<input type="radio" name="option-choice" id="pertanyaan1_col2_2" value="2" required>
				<label for="pertanyaan1_col2_2" data-option-choice="TS"></label>
				<input type="radio" name="option-choice" id="pertanyaan1_col2_3" value="3" required>
				<label for="pertanyaan1_col2_3" data-option-choice="S"></label>
				<input type="radio" name="option-choice" id="pertanyaan1_col2_4" value="4" required>
				<label for="pertanyaan1_col2_4" data-option-choice="SS"></label>
				<div id="option-choice-pos"></div>
			</div>

	      </td>
	    </tr>
	  </tbody>
	</table>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="button" class="btn btn-danger list-data">Kembali</button>
</form>