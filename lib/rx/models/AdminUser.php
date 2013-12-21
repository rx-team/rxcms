<?php

/**
 * This is the model class for table "admin_user".
 *
 * The followings are the available columns in table 'admin_user':
 * @property integer $aid
 * @property string $admin_user
 * @property string $admin_pass
 * @property string $admin_email
 * @property string $admin_name
 * @property string $admin_qq
 */
class AdminUser extends RXActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('admin_user, admin_pass', 'required'),
			array('admin_user, admin_name', 'length', 'max'=>30),
			array('admin_pass', 'length', 'max'=>32),
			array('admin_email', 'length', 'max'=>60),
			array('admin_qq', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('aid, admin_user, admin_pass, admin_email, admin_name, admin_qq', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'aid' => 'Aid',
			'admin_user' => 'Admin User',
			'admin_pass' => 'Admin Pass',
			'admin_email' => 'Admin Email',
			'admin_name' => 'Admin Name',
			'admin_qq' => 'Admin Qq',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('aid',$this->aid);
		$criteria->compare('admin_user',$this->admin_user,true);
		$criteria->compare('admin_pass',$this->admin_pass,true);
		$criteria->compare('admin_email',$this->admin_email,true);
		$criteria->compare('admin_name',$this->admin_name,true);
		$criteria->compare('admin_qq',$this->admin_qq,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}