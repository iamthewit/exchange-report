create table reports
(
    id uuid not null constraint reports_pk primary key,
    trades_executed integer default 0 not null
);

alter table reports
    owner to postgres;

create unique index reports_id_uindex
    on reports (id);