import json
from termcolor import colored


pro_cost = 10.00


with open('data.json') as file:
	data = json.load(file)


def format_playtime(playtime):
	return colored('{:.2f}'.format(playtime/3600), 'blue')


def format_price(price, color='green'):
	return colored('${:.2f}'.format(price),color)


def format_status(status):
	if status == 'liked':
		return colored('Liked and will play more','green')
	elif status == 'not_liked':
		return colored('Not liked and won\'t play more','red')
	elif status == 'play_more':
		return colored('Will play more','yellow')
	else:
		return status


def format_heading(heading):
	return '\n'+colored(heading.upper(),'white')+':\n'

def format_list(list):
	'\n * '.join(paid_games_breakdown),
	if len(list)==0:
		return ''
	else:
		colored_star = colored('*', 'white')
		return ' %s %s' % (colored_star,('\n %s ' % colored_star).join(list))



# GENERAL
pro_months = data['pro_months']
total_pro_games = sum([1 for game in data['games'] if game['price']==0])
purchased_games = sum([1 for game in data['games'] if game['price']!=0])
total_games = total_pro_games+purchased_games

# COST
initial_cost = data['initial_cost']
total_pro_cost = pro_cost*pro_months
total_stadia_cost = initial_cost + total_pro_cost
total_games_cost = sum([game["price"] for game in data['games']])
total_cost = total_stadia_cost + total_games_cost
average_pro_game_cost = total_stadia_cost / total_pro_games

# PLAYTIME
total_playtime = sum([game['playtime'] for game in data['games']])
average_playtime = total_playtime / total_games
total_pro_games_playtime = sum([game['playtime'] for game in data['games'] if game['price']==0])
total_non_pro_games_playtime = total_playtime-total_pro_games_playtime

# GAMES STATS
non_played_games = sum([1 for game in data['games'] if game['playtime']==0])
money_spend_on_not_liked_games = sum([game["price"] for game in data['games'] if game['status']=='not_liked'])
list_of_non_liked_purchased_games = [game["name"] for game in data['games'] if game['status']=='not_liked' and game['price']!=0]
not_liked_pro_games = sum([1 for game in data['games'] if game['status']=='not_liked' and game['price']==0])
list_of_non_liked_pro_games = [game["name"] for game in data['games'] if game['status']=='not_liked' and game['price']==0]

# COST 2
average_liked_pro_game_cost = total_stadia_cost / (total_pro_games - not_liked_pro_games)

# PAID GAMES BREAKDOWN
paid_games_breakdown = {game['price'] / (game['playtime'] / 3600):'{name} ({price}) / {playtime} = {cost_per_hour} ({status})'.format(
		name = game['name'],
		price = format_price(game['price']),
		playtime = format_playtime(game['playtime']),
		cost_per_hour = format_price(game['price'] / (game['playtime'] / 3600),color='red'),
		status = format_status(game['status']),
	) for game in data['games'] if game['price']!=0}
paid_games_breakdown = [paid_games_breakdown[key] for key in sorted(paid_games_breakdown.keys(), reverse=True)]

# NON PLAYED GAMES AND GAMES TO PLAY MORE
play_more_games_breakdown = [game['name'] for game in data['games'] if game['playtime']==0 or game['status']=='play_more']

# PLAY MORE IN THE FUTURE
play_more_in_the_future = [game['name'] for game in data['games'] if game['status']=='liked']


print(
	(
		format_heading('general') +
		'Pro months: {pro_months}\n'+
		'Total Pro Games: {total_pro_games}\n' +
		'Purchased Games: {purchased_games}\n' +
		'Total Games: {total_games}\n' +
		format_heading('cost') +
		'Initial cost: {initial_cost}\n'+
		'Total Pro Cost: {total_pro_cost}\n'+
		'Total Stadia Cost: {total_pro_cost}\n'+
		'Total Games Cost: {total_games_cost}\n'+
		'Total Cost: {total_cost}\n' +
		format_heading('playtime') +
		'Total Playtime: {total_playtime}\n' +
		'Total Pro Games Playtime: {total_pro_games_playtime}\n' +
		'Total Non Pro Games Playtime: {total_non_pro_games_playtime}\n' +
		'Average playtime: {average_playtime}\n' +
		format_heading('games stats') +
		'Non played games: {non_played_games}\n' +
		'Average pro game cost: {average_pro_game_cost}\n' +
		'Average liked pro game cost: {average_liked_pro_game_cost}\n' +
		'Money spent on not liked games: {money_spend_on_not_liked_games}\n' +
		'Not liked pro games: {not_liked_pro_games}\n' +
		format_heading('paid games breakdown') +
		'{paid_games_breakdown}\n' +
		format_heading('non played or play more') +
		'{play_more_games_breakdown}\n' +
		format_heading('play more in the future') +
		'{play_more_in_the_future}\n'
	).format(
		pro_months=pro_months,
		initial_cost=format_price(initial_cost),
		total_pro_cost=format_price(total_pro_cost),
		total_games_cost=format_price(total_games_cost),
		total_cost=format_price(total_cost),
		total_pro_games=total_pro_games,
		purchased_games=purchased_games,
		total_games=total_games,
		total_playtime=format_playtime(total_playtime),
		average_playtime=format_playtime(average_playtime),
		non_played_games=non_played_games,
		average_pro_game_cost=format_price(average_pro_game_cost),
		average_liked_pro_game_cost=format_price(average_liked_pro_game_cost),
		total_pro_games_playtime=format_playtime(total_pro_games_playtime),
		total_non_pro_games_playtime=format_playtime(total_non_pro_games_playtime),
		money_spend_on_not_liked_games='%s (%s)' % (format_price(money_spend_on_not_liked_games),', '.join(list_of_non_liked_purchased_games)),
		not_liked_pro_games='%d games (%s)' % (not_liked_pro_games,', '.join(list_of_non_liked_pro_games)),
		paid_games_breakdown=format_list(paid_games_breakdown),
		play_more_games_breakdown=format_list(play_more_games_breakdown),
		play_more_in_the_future=format_list(play_more_in_the_future)
	)
)
