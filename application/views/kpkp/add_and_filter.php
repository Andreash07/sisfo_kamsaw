<div style="display:flex; justify-content:space-between;">
  <button
    class="btn btn-primary"
    data-toggle="modal"
    data-target=".modal-blok-makam">
    Tambah data
  </button>
  <div style="display: flex; gap: 2rem;">
    <select type="text" id="cari-data-makam-blok" class="form-control" style="width:8rem;">
        <option value="">Blok</option>
        <option value="A" <?php if(strtolower($this->input->get('blok'))=='a'){echo "selected";} ?>>A</option>
        <option value="B" <?php if(strtolower($this->input->get('blok'))=='b'){echo "selected";} ?>>B</option>
        <option value="C" <?php if(strtolower($this->input->get('blok'))=='c'){echo "selected";} ?>>C</option>
        <option value="D" <?php if(strtolower($this->input->get('blok'))=='d'){echo "selected";} ?>>D</option>
        <option value="E" <?php if(strtolower($this->input->get('blok'))=='e'){echo "selected";} ?>>E</option>
        <option value="F" <?php if(strtolower($this->input->get('blok'))=='f'){echo "selected";} ?>>F</option>
        <option value="G" <?php if(strtolower($this->input->get('blok'))=='g'){echo "selected";} ?>>G</option>
        <option value="H" <?php if(strtolower($this->input->get('blok'))=='h'){echo "selected";} ?>>H</option>
        <option value="I" <?php if(strtolower($this->input->get('blok'))=='i'){echo "selected";} ?>>I</option>
        <option value="J" <?php if(strtolower($this->input->get('blok'))=='j'){echo "selected";} ?>>J</option>
        <option value="K" <?php if(strtolower($this->input->get('blok'))=='k'){echo "selected";} ?>>K</option>
        <option value="L" <?php if(strtolower($this->input->get('blok'))=='l'){echo "selected";} ?>>L</option>
        <option value="M" <?php if(strtolower($this->input->get('blok'))=='m'){echo "selected";} ?>>M</option>
        <option value="N" <?php if(strtolower($this->input->get('blok'))=='n'){echo "selected";} ?>>N</option>
        <option value="O" <?php if(strtolower($this->input->get('blok'))=='o'){echo "selected";} ?>>O</option>
    </select>
    <input type="number" id="cari-data-makam-kavling" class="form-control" placeholder="Kavling" style="width:120px;" value="<?=$this->input->get('kavling');?>" />
    <button id="cari-data-makam" class="btn btn-primary">Cari</button>
  </div>
</div>