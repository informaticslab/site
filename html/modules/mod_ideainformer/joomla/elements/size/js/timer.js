
function Timer(nPauseTime) {
	this._pauseTime = typeof nPauseTime == "undefined" ? 1000 : nPauseTime;
	this._timer = null;
	this._isStarted = false;
}

Timer.prototype.start = function () {
	if (this.isStarted())
		this.stop();
	var oThis = this;
	this._timer = window.setTimeout(function () {
		if (typeof oThis.ontimer == "function")
			oThis.ontimer();
	}, this._pauseTime);
	this._isStarted = false;
};

Timer.prototype.stop = function () {
	if (this._timer != null)
		window.clearTimeout(this._timer);
	this._isStarted = false;
};

Timer.prototype.isStarted = function () {
	return this._isStarted;
};

Timer.prototype.getPauseTime = function () {
	return this._pauseTime;
};

Timer.prototype.setPauseTime = function (nPauseTime) {
	this._pauseTime = nPauseTime;
};