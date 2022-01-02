create table totals_report
(
    id uuid not null constraint reports_pk primary key,
    trades_executed integer default 0 not null,
    traders_on_exchange integer default 0 not null,
    share_on_exchange integer default 0 not null
);

alter table totals_report
    owner to postgres;

create unique index reports_id_uindex
    on totals_report (id);

-- TODO: remove this when we get rid of the hardcoded report id
insert into totals_report(id)
values('f7119b91-1928-44ce-891b-f8c7b52026fc')