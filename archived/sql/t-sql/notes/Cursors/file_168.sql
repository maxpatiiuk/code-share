#CURSOR - array

declare
ShowAvtos cursor for # == local
#ShowAvtos cursor local for
#ShowAvtos cursor global for - (global - use from different file)
#ShowAvtos scroll cursor global for - (scroll - for use of absolute )
#ShowAvtos scroll cursor local for
select [nomer], [kolir], [data_vur]
from [dbo].[avto]
  declare
  @nom varchar (Max),
  @kol varchar (Max),
  @ data date
  open ShowAvtos
  while 1=1
begin fetch ShowAvtos into @nom, @kol, @data
	if @@FETCH_STATUS <> 0
		break
	print @nom + ' ' + @kol + ' ' + cast(@data as varchar)
end

# delete from [dbo].[avto] where current of ShowAvtos
# update [dbo].[avto] set kolir = 'new_black' where current of ShowAvtos

close ShowAvtos
deallocate
ShowAvtos

# Def or scroll
#fetch next from ShowAvtos into @nom, @kol, @data

# only scroll cursor
#fetch last from ShowAvtos into @nom, @kol, @data
#fetch prior from ShowAvtos into @nom, @kol, @data
#fetch first from ShowAvtos into @nom, @kol, @data
#fetch absolute 1 from ShowAvtos into @nom, @kol, @data - cursor should be dynamic
#fetch relative -3 from ShowAvtos into @nom, @kol, @data - cursor should be dynamic