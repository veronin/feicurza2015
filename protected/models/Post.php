<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property User $author
 * @property Comment[] $comments
 */
class Post extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}
        public $nusuario;
	/**
	 * @return array validation rules for model attributes.
	*/
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status', 'required'),
			array('status', 'in', 'range'=> array(1,2,3)),             
			array('title', 'length', 'max'=>128),
			array('tags', 'normalizeTags'),
                        array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/',
                              'message'=>'Tags can only contain word characters.'),
                    
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
                        //Agrego nusuario para que forme parte de los campos a buscar
                        array('title, status, nusuario', 'safe', 'on'=>'search'),           
                );
        
	}
        public function normalizeTags($attribute, $params)
        {
            $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
        }
	
        /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id',
                            'condition'=>'comments.status='.Comment::STATUS_APPROVED,
                            'order'=>'comments.create time DESC'),
                        'commentCount' => array(self::STAT, 'Comment', 'post_id',
                            'condition'=>'status='.Comment::STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                        'nusuario' => 'User Name',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
		);
	}

        public function getNombreUsuario()
        {
            if ($this->author != null)
            { return "<b>".$this->author->username."</b>";}
            else {return '';}
        }        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
                // Uso la relacion para buscar
                $criteria->with=array('author');
                
                //Comparo con el campo que se lleno para la busqueda 
                $criteria->compare('author.username',$this->nusuario, true);
                
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('author_id',$this->author_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'nusuario'=>array(
                                        'asc'=>'author.username',
                                        'desc'=>'author.username DESC',
                                ),
                            '*',
                            ),
                        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getUrl()
        {
        return Yii::app()->createUrl('post/view', array('id'=>$this->id,'title'=>$this->title,));
        }
        
        
        
}
