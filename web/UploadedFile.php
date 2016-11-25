<?php
class UploadedFile extends \yii\web\UploadedFile {
	/**
	 * Saves the uploaded file.
	 * Note that this method uses php's move_uploaded_file() method. If the target file `$file`
	 * already exists, it will be overwritten.
	 *
	 * @param string $file
	 *        	the file path used to save the uploaded file
	 * @param boolean $deleteTempFile
	 *        	whether to delete the temporary file after saving.
	 *        	If true, you will not be able to save the uploaded file again in the current request.
	 * @return boolean true whether the file is saved successfully
	 * @see error
	 */
	public function saveAs($file, $deleteTempFile = true) {
		if ($this->error == UPLOAD_ERR_OK) {
			if ($deleteTempFile) {
				return rename ( $this->tempName, $file );
			} elseif (is_uploaded_file ( $this->tempName )) {
				return copy ( $this->tempName, $file );
			}
		}
		return false;
	}
}