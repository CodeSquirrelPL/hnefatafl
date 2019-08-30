function data(label, value, box) {

  this.label = label;
  this.value = value;
  this.box = box;

  this.feedback = function(content) {
    this.box.php(content);
  }
}
