const random_hex = size => [...Array(size)].map(() => Math.floor(Math.random() * 16).toString(16)).join('');

function random_color(){
	return '#'+random_hex().repeat(3);
}