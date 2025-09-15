<script>
    class Post extends BaseClass {
        all_categories = @json(\App\Model\Admin\PostCategory::getForSelect());
        statuses = @json(\App\Model\Admin\Post::STATUSES);
        no_set = [];

        before(form) {
            this.image = {};
            this.status = 0;
        }

        after(form) {

        }

        get time() {
            // AngularJS ng-model cần 1 Date object ổn định
            if (this._time && !this._timeObj) {
                this._timeObj = moment(this._time, 'YYYY-MM-DD').toDate();
            }
            return this._timeObj;
        }

        set time(value) {
            // AngularJS sẽ đưa Date object vào đây
            console.log(value);
            this._timeObj = value instanceof Date ? value : moment(value).toDate();
            this._time = this._timeObj ?
                moment(this._timeObj).format('YYYY-MM-DD') :
                null;
        }

        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }

        get submit_data() {
            let data = {
                name: this.name,
                cate_id: this.cate_id,
                intro: this.intro,
                body: this.body,
                status: this.status,
                time: this._time,
            }

            data = jsonToFormData(data);
            let image = $(`#${this.image.element_id}`).get(0).files[0];
            if (image) data.append('image', image);
            return data;
        }
    }
</script>
