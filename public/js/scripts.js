var qHandler = {
    userId: undefined,
    currentQuestion: 0,
    questions: [],
    callApi: function (url, cb, data, method) {
        jQuery.ajax({
            type: method ? method : "POST",
            dataType: "json",
            data: data,
            url: APP_URL + "/api/v1/" + url,
            success: function (response) {
                if(response.message) {
                    toastr.success(response.message);
                }
                if(typeof cb === "function") {
                    cb(response);
                }
            },
            error: function (data) {
                let response = data.responseJSON;
                if(response.message) {
                    toastr.error(response.message);
                }
                if(typeof cb === "function") {
                    cb(response, true);
                }
            }
        });
    },

    renderUserDetails: function () {
        $('.container').html(`<div class="card">
            <div class="card-header">
                <h2>User Details</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="question1">Name</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" value="">
                    </div>
                </div>
                <!-- Add more questions as needed -->
                <button type="button" class="btn btn-primary" id="save-user">Next</button>
            </div>
        </div>`);
    },

    renderQuestion: function (isNextQuestion = false) {
        if(isNextQuestion) {
            this.currentQuestion++;
        }

        if(this.questions[this.currentQuestion] !== undefined) {
            let question = this.questions[this.currentQuestion],
                answers = '';
            console.log("rendering question", question);
            $.each(question.answers, function (i, answer) {
                answers += `<div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" id="answer-${i}"  value="${answer.id}">
                            <label class="form-check-label" for=answer-${i}">
                                ${answer.text}
                            </label>
                        </div>`;
            });

            $('.container').html(`<div class="card">
                <div class="card-header">
                    <h2 id="question-no">Question ${this.currentQuestion + 1}</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="question" id="question-title">${question.text}</label>
                        ${answers}
                    </div>
                    <!-- Add more questions as needed -->
                    <input type="hidden" name="question_id" value="${question.id}">
                    <button type="button" class="btn btn-secondary" id="skipButton">Skip</button>
                    <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                </div>
            </div>`);
        } else {
            let $self =this;
            this.callApi(`user/${$self.userId}/results`, function (response, isError){
                $self.showResults(response.result);
            }, {}, "GET");
        }
    },

    getAnswerDetails: function (isSkipped = false) {
        let questionId = $("input[name=question_id]").val();
        if(isSkipped) {
            return { user_id: this.userId, question_id: questionId, is_skipped: 1};
        }
        return {user_id: this.userId, question_id: questionId, answer_id: $("input[name=answer]").val()}
    },

    showResults: function (result) {
        $('.container').html(`<div class="card">
            <div class="card-header">
                Results
            </div>
            <div class="card-body">
                <p class="card-text">Total records: <strong>${result.total}</strong></p>
                <p class="card-text">Wrong Answers: <strong>${result.wrong}</strong></p>
                <p class="card-text">Skipped records: <strong>${result.skipped}</strong></p>
            </div>
        </div>`);
    }
};


jQuery(document).ready(function (){
    qHandler.renderUserDetails();

    jQuery(document).off("click", "#save-user").on("click", "#save-user", function (){
        let name = $("input[name=name]").val();
        if(name !== "") {
            qHandler.callApi("user/save", function (response) {
                if(response.status) {
                    qHandler.userId = response.result;
                    if (qHandler.userId) {
                        qHandler.callApi("question", function (response) {
                            qHandler.questions = response.result;
                            qHandler.renderQuestion();
                        }, {}, "GET");
                    }
                }
            }, { name: name});
        } else {
            toastr.error('Please enter name');
        }
    });

    jQuery(document).off("click", "#skipButton").on("click", "#skipButton", function (){
        console.log("skipped answer...");
        qHandler.callApi( "user/save-answer", function (response, isError) {
            if(isError === undefined) {
                qHandler.renderQuestion(true);
            }
        }, qHandler.getAnswerDetails(true));
    });

    jQuery(document).off("click", "#nextButton").on("click", "#nextButton", function (){
        console.log("submitting answer...");
        qHandler.callApi("user/save-answer", function (response, isError) {
            if(isError === undefined) {
                qHandler.renderQuestion(true);
            }
        }, qHandler.getAnswerDetails());
    });

});
